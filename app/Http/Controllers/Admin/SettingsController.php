<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SettingsController extends Controller
{

    public function index()
    {
        return view('admin.settings.index');
    }


    public function update(Request $request)
    {
        // الحقول النصية
        $textFields = [
            'phone_number', 'email', 'address_en', 'address_ar',
            'freelancers_availability_percentage',
            'name_en', 'name_ar', 'slogan_en', 'slogan_ar',
            'meta_description_en', 'meta_description_ar',
            'meta_keywords_en', 'meta_keywords_ar',
            'social_title_en', 'social_title_ar',
            'social_description_en', 'social_description_ar',
            'facebook', 'instagram', 'linkedin', 'twitter', 'whats sap', 'tiktok', 'whatsapp'
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                Setting::setValue($field, $request->input($field));
            }
        }

        $imageFields = ['favicon', 'white_logo', 'logo'];

        foreach ($imageFields as $field) {
            $setting = Setting::firstOrCreate(['key' => $field]);

            if ($request->hasFile($field)) {
                $setting->clearMediaCollection($field);

                $media = $setting->addMediaFromRequest($field)
                    ->usingFileName(Str::random(20) . '.' . $request->file($field)->getClientOriginalExtension())
                    ->toMediaCollection($field, 'settings');

                // تخزين اسم المجلد/اسم الصورة
                $setting->value = $field . '/' . $media->file_name;
                $setting->save();

            } elseif ($request->input($field . '_remove') == '1') {
                $setting->clearMediaCollection($field);
                $setting->value = null;
                $setting->save();
            }
        }


        Cache::forget('settings_cache');

        return response()->json([
            'success' => true,
            'message' => __('Settings updated successfully.'),
        ]);
    }

}
