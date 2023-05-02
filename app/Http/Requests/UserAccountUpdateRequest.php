<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAccountUpdateRequest extends FormRequest
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
        $id = $this->user;
        return [
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => ['nullable', 'string', 'min:6'],
            'password_confirmation' => ['nullable', 'required_with:password', 'same:password'],
        ];
    }
}
