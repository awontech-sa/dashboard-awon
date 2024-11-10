<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'password' => 'nullable|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$#%]).*$/',
            'phone_number' => 'nullable|string|max:15|regex:/^\+?[0-9\s-]*$/',
            'x' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255|url',
            'profile-image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_verified' => 'nullable|boolean'
        ];
    }
}
