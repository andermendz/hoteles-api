<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:hotels',
            'address' => 'required',
            'city' => 'required',
            'nit' => [
                'required',
                'unique:hotels',
                'regex:/^\d{9}-\d$/' // Formato: #########-#
            ],
            'total_rooms' => 'required|integer|min:1',
            'rooms' => 'required|array',
            'rooms.*.room_type_id' => 'required|exists:room_types,id',
            'rooms.*.accommodation_id' => [
                'required',
                'exists:accommodations,id',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $roomTypeId = $this->input("rooms.{$index}.room_type_id");
                    
                    // Validaciones específicas según tipo de habitación
                    if ($roomTypeId == 1) { // ESTANDAR
                        if (!in_array($value, [1, 2])) { // SENCILLA o DOBLE
                            $fail('La habitación Estándar solo permite acomodación Sencilla o Doble.');
                        }
                    } elseif ($roomTypeId == 2) { // JUNIOR
                        if (!in_array($value, [3, 4])) { // TRIPLE o CUÁDRUPLE
                            $fail('La habitación Junior solo permite acomodación Triple o Cuádruple.');
                        }
                    } elseif ($roomTypeId == 3) { // SUITE
                        if (!in_array($value, [1, 2, 3])) { // SENCILLA, DOBLE o TRIPLE
                            $fail('La habitación Suite solo permite acomodación Sencilla, Doble o Triple.');
                        }
                    }
                }
            ],
            'rooms.*.quantity' => 'required|integer|min:1'
        ];
            
    }
    
    public function messages(): array
    {
        return [
            'nit.regex' => 'El NIT debe tener el formato: #########-# (9 números, guión, 1 número)'
        ];
    }
}