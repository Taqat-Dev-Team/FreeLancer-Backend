<?php

namespace App\Http\Requests\Front\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
    public function rules()
    {
        return [


            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'file_format' => 'nullable|array',
            'file_format.*' => 'string',

            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',

            'days' => 'required|integer|min:1',
            'revisions' => 'required|string|max:20',

            'price' => 'required|numeric|min:0',

            'add_ons' => 'nullable|array',
            'add_ons.*.title' => 'required|string|max:255',
            'add_ons.*.price' => 'required|numeric|min:0',
            'add_ons.*.additional_days' => 'nullable|numeric|min:0',

            'freelancer_id' => 'required|exists:freelancers,id',

            // --- قواعد جديدة من الصور ---

            // لملخص المشروع (description في الموديل)
            'description_summary' => 'required|string|min:10|max:250',

            // لمتطلبات العميل (requirements في الموديل)
            'requirements' => 'nullable|array',
            'requirements.*.description' => 'required|string|min:10|max:250',
            'requirements.*.allow_attachments' => 'nullable|boolean',
            'requirements.*.client_must_answer' => 'nullable|boolean',

            // للأسئلة الشائعة (questions في الموديل)
            'faqs' => 'nullable|array|max:5', // بحد أقصى 5 أسئلة
            'faqs.*.question' => 'required|string|max:255',
            'faqs.*.answer' => 'required|string',

            // لصور المشروع (إذا كانت تُرسل كملفات لـ Spatie)
            'images' => 'required|array|min:1|max:20', // على الأقل صورة واحدة، بحد أقصى 20
            'images.*' => 'image|mimes:jpeg,png,jpg|max:10240', // 10MB كحد أقصى
            // هنا، بدلاً من cover_image_index، ستحدد أي من الـ media item هو الغلاف بعد التحميل
            // أو ترسل معرف الصورة المختارة كغلاف إذا كانت موجودة مسبقًا
            // إذا كنت ترسلها لأول مرة، ستحتاج إلى طريقة لتحديدها.
            // لنفترض أنك ترسل فهرس الصورة التي ستكون الغلاف من الصور المرسلة حديثًا.
            'cover_image_index' => 'required|integer|min:0|max:' . (count($this->file('images') ?? []) - 1),



        ];
    }

    public function messages()
    {
        return [

            // --- رسائل جديدة للتحقق ---
            'description_summary.required' => 'ملخص المشروع مطلوب.',
            'description_summary.string' => 'ملخص المشروع يجب أن يكون نصاً.',
            'description_summary.min' => 'يجب أن يكون ملخص المشروع 10 أحرف على الأقل.',
            'description_summary.max' => 'يجب ألا يتجاوز ملخص المشروع 250 حرفاً.',

            'requirements.array' => 'يجب أن تكون المتطلبات في شكل مصفوفة.',
            'requirements.*.description.required' => 'وصف المتطلب مطلوب.',
            'requirements.*.description.string' => 'وصف المتطلب يجب أن يكون نصاً.',
            'requirements.*.description.min' => 'يجب أن يكون وصف المتطلب 10 أحرف على الأقل.',
            'requirements.*.description.max' => 'يجب ألا يتجاوز وصف المتطلب 250 حرفاً.',
            'requirements.*.allow_attachments.boolean' => 'قيمة السماح بالمرفقات يجب أن تكون صحيحة أو خاطئة.',
            'requirements.*.client_must_answer.boolean' => 'قيمة إلزام العميل بالإجابة يجب أن تكون صحيحة أو خاطئة.',





            // رسائل للأسئلة الشائعة
            'faqs.array' => 'يجب أن تكون الأسئلة الشائعة في شكل مصفوفة.',
            'faqs.max' => 'الحد الأقصى للأسئلة الشائعة هو 5 أسئلة.',
            'faqs.*.question.required' => 'السؤال مطلوب في الأسئلة الشائعة.',
            'faqs.*.question.string' => 'السؤال في الأسئلة الشائعة يجب أن يكون نصاً.',
            'faqs.*.question.max' => 'يجب ألا يتجاوز السؤال في الأسئلة الشائعة 255 حرفاً.',
            'faqs.*.answer.required' => 'الإجابة مطلوبة في الأسئلة الشائعة.',
            'faqs.*.answer.string' => 'الإجابة في الأسئلة الشائعة يجب أن تكون نصاً.',



            // رسائل الصور
            'images.required' => 'الرجاء تحميل صورة واحدة على الأقل للمشروع.',
            'images.array' => 'يجب أن تكون صور المشروع في مصفوفة.',
            'images.min' => 'الرجاء تحميل صورة واحدة على الأقل للمشروع.',
            'images.max' => 'الحد الأقصى لصور المشروع هو 20 صورة.',
            'images.*.image' => 'يجب أن يكون كل ملف من ملفات الصور صورة صالحة.',
            'images.*.mimes' => 'يجب أن تكون صور المشروع من الأنواع التالية: jpeg, png, jpg.',
            'images.*.max' => 'يجب ألا يتجاوز حجم كل صورة 10 ميغابايت.',
            'cover_image_index.required' => 'الرجاء تحديد صورة غلاف.',
            'cover_image_index.integer' => 'فهرس صورة الغلاف يجب أن يكون رقماً صحيحاً.',
            'cover_image_index.min' => 'فهرس صورة الغلاف غير صالح.',
            'cover_image_index.max' => 'فهرس صورة الغلاف غير صالح.',


            'title.required' => __('validation.title_required'),
            'title.string' => __('validation.title_string'),
            'title.max' => __('validation.title_max'),

            'category_id.exists' => __('validation.category_id_exists'),
            'sub_category_id.exists' => __('validation.sub_category_id_exists'),

            'file_format.array' => __('validation.file_format_array'),
            'file_format.*.string' => __('validation.file_format_string'),

            'tags.array' => __('validation.tags_array'),
            'tags.*.string' => __('validation.tags_string'),
            'tags.*.max' => __('validation.tags_max'),

            'days.required' => __('validation.days_required'),
            'days.integer' => __('validation.days_integer'),
            'days.min' => __('validation.days_min'),

            'revisions.required' => __('validation.revisions_required'),
            'revisions.string' => __('validation.revisions_string'),
            'revisions.max' => __('validation.revisions_max'),

            'price.required' => __('validation.price_required'),
            'price.numeric' => __('validation.price_numeric'),
            'price.min' => __('validation.price_min'),

            'add_ons.array' => __('validation.add_ons_array'),
            'add_ons.*.title.required' => __('validation.add_ons_title_required'),
            'add_ons.*.title.string' => __('validation.add_ons_title_string'),
            'add_ons.*.title.max' => __('validation.add_ons_title_max'),

            'add_ons.*.price.required' => __('validation.add_ons_price_required'),
            'add_ons.*.price.numeric' => __('validation.add_ons_price_numeric'),
            'add_ons.*.price.min' => __('validation.add_ons_price_min'),

            'add_ons.*.additional_days.numeric' => __('validation.add_ons_additional_days_numeric'),
            'add_ons.*.additional_days.min' => __('validation.add_ons_additional_days_min'),

            'freelancer_id.required' => __('validation.freelancer_id_required'),
            'freelancer_id.exists' => __('validation.freelancer_id_exists'),
        ];
    }


}
