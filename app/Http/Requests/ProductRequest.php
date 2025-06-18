<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins can manage products
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'in:chicken,burger,sides,drinks,desserts'],
            'available' => ['boolean', 'nullable'],
        ];
        
        // Only require image on create, not on update
        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:2048']; // 2MB max
        } else {
            $rules['image'] = ['nullable', 'image', 'max:2048']; // Optional on update
        }
        
        return $rules;
    }
}
