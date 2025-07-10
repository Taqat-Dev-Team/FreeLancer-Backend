<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        return view('admin.settings.index');
    }


    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate([]);
        $textFields = [
            'phone_number', 'email', 'address_en', 'address_ar',
            'freelancers_availability_percentage',
            'name_en', 'name_ar', 'slogan_en', 'slogan_ar',
            'meta_description_en', 'meta_description_ar',
            'meta_keywords_en', 'meta_keywords_ar',
            'social_title_en', 'social_title_ar',
            'social_description_en', 'social_description_ar',
            'facebook', 'instagram', 'linkedin', 'twitter',
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $setting->$field = $request->input($field);
            }
        }
        $setting->save();

        $imageFields = ['favicon', 'white_logo', 'logo'];

        foreach ($imageFields as $imageField) {
            if ($request->hasFile($imageField)) {
                $setting->clearMediaCollection($imageField);

                $setting->addMediaFromRequest($imageField)->toMediaCollection($imageField);
            } elseif ($request->has($imageField . '_remove') && $request->input($imageField . '_remove') == '1') {
                $setting->clearMediaCollection($imageField);
            }
        }

        return response()->json([
            'success' => true,
            'message' => __('Settings updated successfully.'),
            'data' => $setting,
        ]);
    }


}
