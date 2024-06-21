<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            //
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|digits:10',
            'customer_address' => 'required|string|max:255',
            'ordered_date' => 'required|date',
            'estimate_delivery_date' => 'required|date',
            'process_steps_order' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.string' => 'Customer name must be a string.',
            'customer_name.max' => 'Customer name cannot be more than 255 characters.',

            'customer_phone.required' => 'Customer phone number is required.',
            'customer_phone.numeric' => 'Customer phone number must be numeric.',
            'customer_phone.digits' => 'Customer phone number must be exactly 10 digits.',

            'customer_address.required' => 'Customer address is required.',
            'customer_address.string' => 'Customer address must be a string.',
            'customer_address.max' => 'Customer address cannot be more than 255 characters.',

            'ordered_date.required' => 'Ordered date is required.',
            'ordered_date.date' => 'Ordered date must be a valid date.',

            'estimate_delivery_date.required' => 'Estimate delivery date is required.',
            'estimate_delivery_date.date' => 'Estimate delivery date must be a valid date.',

            'process_steps_order.required' => 'Process steps are required.',
            'process_steps_order.array' => 'Process steps must be selected from the list.',
        ];
    }
}
