<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
     * Determine if the user is authorized to make this request.
     */
class StoreCategoryRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('categories', 'name->ar')],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('categories', 'name->en')],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.required' => 'The English name is required.',
            'icon.required' => 'The icon is required.',
        ];
    }

}
