<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Rent extends FormRequest
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
            'price'               => 'numeric|nullable',
            'previous_price'      => 'numeric|nullable',
            'management_fee'      => 'numeric|nullable',
            'monthly_fee'         => 'numeric|nullable',
            'security_deposit'    => 'numeric|nullable',
            'gratuity_fee'        => 'numeric|nullable',
            'deposit'             => 'numeric|nullable',
            'company_name'        => 'string|nullable|max:255',
            'contact_phonenumber' => 'string|nullable',
            'pic'                 => 'string|nullable|max:255',
            'email'               => 'email|nullable|max:255',
            'registered_at'       => 'date|nullable',
            'changed_at'          => 'date|nullable',

            'sold_price'               => 'numeric|nullable',
            'sold_previous_price'      => 'numeric|nullable',
            'sold_registered_at'       => 'date|nullable',
            'sold_changed_at'          => 'date|nullable',
        ];
    }
}
