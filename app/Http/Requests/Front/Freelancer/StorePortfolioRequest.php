<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;


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
        return [
            'title' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'tags' => 'nullable|string',
            'content_blocks' => 'nullable|array',
            'content_blocks.*.type' => 'required_with:content_blocks|in:image,text',
        ];
    }

    public function messages()
    {
        return [
            'title.string' => __('validation.title_string'),
            'title.max' => __('validation.title_max'),

            'main_image.image' => __('validation.main_image_image'),
            'main_image.mimes' => __('validation.main_image_mimes'),
            'main_image.max' => __('validation.main_image_max'),

            'tags.string' => __('validation.tags_string'),

            'content_blocks.array' => __('validation.content_blocks_array'),
            'content_blocks.*.type.required_with' => __('validation.content_block_type_required'),
            'content_blocks.*.type.in' => __('validation.content_block_type_in'),
        ];
    }

}
