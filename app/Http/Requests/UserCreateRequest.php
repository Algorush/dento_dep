<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
        $color_validation = 'nullable|regex:/^#[A-Fa-f0-9]{6}$/';

        return [
            'primary_color' => $color_validation,
            'header_color' => $color_validation,
            'body_color' => $color_validation,
            'text_color' => $color_validation,
            'background_color' => $color_validation,
            'progressbar_color' => $color_validation,
            'progressbar_background_color' => $color_validation,
            'point_text_header_1' => ['required'],
            'point_text_header_2' => ['required'],
            'point_text_header_3' => ['required'],
            'point_text_header_4' => ['required'],
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string|confirmed|min:6',
            'pdf' => 'sometimes|mimes:pdf',
        ];
    }
    
    public function messages()
    {
        return [
            'point_text_header_1.required' => 'How to wear your Aligners Text is required',
            'point_text_header_2.required' => 'Wear Sсhedule Text is required',
            'point_text_header_3.required' => 'Treatment Duration Text is required',
            'point_text_header_4.required' => 'Patient Text is required'
        ];
    }
}
