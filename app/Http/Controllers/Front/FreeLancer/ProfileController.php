<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Freelancer\AbouteRequest;
use App\Http\Requests\Front\Freelancer\LanguagesRequest;
use App\Http\Requests\Front\Freelancer\SaveDataRequest;
use App\Http\Requests\Front\Freelancer\SkillsRequest;
use App\Http\Requests\Front\Freelancer\SocialsRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    use ApiResponseTrait;

    public function saveData(SaveDataRequest $request)
    {
        $user = Auth::user();
        $token = $this->extractBearerToken($request);

        if ($user->save_data) {
            return $this->apiResponse(
                ['save_data' => 1],
                __('messages.Access Denied, already saved data'),
                false,
                401
            );
        }

        try {


            $user->fill([
                'name' => $request->name,
                'bio' => $request->bio ?? '',
                'birth_date' => $request->birth_date,
                'country_id' => $request->country_id,
                'gender' => $request->gender,
                'save_data' => 1,
                'mobile' => $request->mobile,
            ]);

            // معالجة الصورة
            if ($request->hasFile('photo')) {
                $user->clearMediaCollection('photo');
                $user->addMediaFromRequest('photo')
                    ->usingFileName(Str::random(20) . '.' . $request->file('photo')->getClientOriginalExtension())
                    ->toMediaCollection('photo', 'freelancers');
            }

            // تحديث بيانات الفريلانسر المرتبطة
            $freelancer = $user->freelancer;
            $freelancer->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'available_hire' => $request->available_hire ?? false,
                'hourly_rate' => $request->hourly_rate ?? null,
            ]);

            if ($request->has('skills')) {
                $freelancer->skills()->sync($request->skills);
            }

            $user->save();

            $user->load([
                'freelancer.skills',
                'freelancer.category',
                'freelancer.subCategory'
            ]);

            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);
        }
    }


    public function updateAbout(AbouteRequest $request)
    {
        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);
            $freelancer = $user->freelancer;

            $user->update(['country_id' => $request->country_id]);

            $freelancer->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'available_hire' => $request->available_hire ?? false,
                'hourly_rate' => $request->hourly_rate ?? null,
                'experience' => $request->experience,

            ]);


            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );

        } catch (Exception $e) {
            Log::error('Error saving user data.', ['user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }
    }


    public function updateSkills(SkillsRequest $request)
    {

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);

            $freelancer = $user->freelancer;


            $freelancer->skills()->sync($request->skills);





            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }}


    public function updateLanguages(LanguagesRequest $request)
    {

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);

            $freelancer = $user->freelancer;

            foreach ($request->languages as $lang) {
                $languageData[$lang['language_id']] = ['level' => $lang['level']];
            }

            $freelancer->languages()->sync($languageData);


            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }}

    public function updateSocials(SocialsRequest $request)
    {

        try {
            $user = Auth::user();
            $token = $this->extractBearerToken($request);
            $freelancer = $user->freelancer;


            foreach ($request->socials as $social) {
                $Data[$social['social_id']] = ['link' => $social['link']];
            }

            $freelancer->socials()->sync($Data);



            return $this->apiResponse(
                new UserResource($user, $token),
                __('messages.data_saved_successfully'),
                true,
                200
            );
        } catch (Exception $e) {
            Log::error('Error saving user data.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $this->apiResponse([], __('messages.data_save_failed'), false, 500);

        }}


    }
