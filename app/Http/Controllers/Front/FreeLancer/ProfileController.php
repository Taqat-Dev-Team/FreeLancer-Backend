<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;

use App\Http\Requests\Front\FreelancerProfileRequest;
use App\Http\Resources\UserResource;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    use ApiResponseTrait;

    public function saveData(FreelancerProfileRequest $request)
    {

        $user = Auth::user();


        if (!$user) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $token = $this->extractBearerToken($request);

        try {

            $user->fill([
                'name' => $request->name,
                'bio' => $request->bio ?? '',
                'birth_date' => $request->birth_date,
                'country_id' => $request->country_id,
                'gender' => $request->gender,
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
            ]);

            $user->save();

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


    private function extractBearerToken(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        return $authHeader && str_starts_with($authHeader, 'Bearer ')
            ? substr($authHeader, 7)
            : null;
    }


}
