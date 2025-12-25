<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post') && $this->is('registration')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'post' => 'required|string|max:255',
                'mobile' => 'required|numeric|digits:10',
                'address' => 'required|string|max:255',
                'qualification' => 'required|string|max:255',
                'experience' => 'required|numeric',
                'joining' => 'required|date',
                'working_from' => 'required|date_format:H:i',
                'working_to' => 'required|date_format:H:i',
                'role' => 'required|exists:roles,name'
            ];
        }
        return [];
    }
}
