<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployeeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [          
                'emp_name' => 'required|string|max:50',
                'phone' => 'required|numeric|digits:10',
                'email' => 'required|email|unique:users,email', 
                'password' => 'required|string|min:8|confirmed',
            
        ];
    }

    public function messages()
    {
        return [
            'emp_name.required' => 'The employee name is required.',
            'emp_name.string' => 'The employee name must be a string.',
            'emp_name.max' => 'The employee name may not be greater than 50 characters.',
            
            'phone.required' => 'The phone number is required.',
            'phone.numeric' => 'The phone number must be a number.',
            'phone.digits' => 'The phone number must be exactly 10 digits.',
            
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
