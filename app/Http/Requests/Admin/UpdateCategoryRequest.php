<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('categories', 'name->ar')->ignore($id)],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('categories', 'name->en')->ignore($id)],
            'icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
