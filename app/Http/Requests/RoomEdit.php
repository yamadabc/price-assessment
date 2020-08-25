<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomEdit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_number' => 'nullable',
            'floor_number' => 'nullable|integer',
            'layout' => 'nullable|string',
            'layout_type' => 'nullable|string',
            'direction' => 'nullable|string',
            'occupied_area' => 'nullable|numeric',
            'published_price' => 'nullable|integer',
            'expected_price' => 'nullable|integer',
            'expected_rent_price' => 'nullable|integer',
            'has_no_data' => 'nullable',
        ];
    }
}
