<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            // 'firstname' => [
            //     'required', 'min:3', 'max:255'
            // ],
            // 'firstname' => [
            //     'required', 'min:3', 'max:255'
            // ],
            // 'phone' => [
            //     'required', 'min:3', 'max:255'
            // ],
            // 'email' => [
            //     'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user ?? null)
            // ],
            'address' => [
                'required', 'min:3', 'max:255'
            ],
            'state' => [
                'required', 'min:3', 'max:255'
            ],
            'lga' => [
                'required', 'min:3', 'max:255'
            ],
            'dob' => [
                'required'
            ]
        ];
    }
}
