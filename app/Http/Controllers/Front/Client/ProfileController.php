<?php

namespace App\Http\Controllers\Front\Client;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;

use App\Http\Resources\UserResource;
use App\Mail\OtpMail;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    use ApiResponseTrait;


    public function saveData(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'nullable|string|max:2000',
            'birth_date' => 'required|date',
            'available_hire' => 'nullable|boolean',
            'category_id'=> 'required|exists:categories,id',
            'sub_category_id'=> 'required|exists:sub_categories,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $token = $this->extractBearerToken($request);

        try {
            $user->name = $validatedData['name'];
            if ($request->hasFile('photo')) {

            }
            $user->bio = $validatedData['bio'] ?? '';
            $user->birth_date = $validatedData['birth_date'];
            $user->available_hire = $validatedData['available_hire'] ?? false;
            $user->save();

            // هنا يمكنك حفظ الفئات والبيانات الأخرى حسب الحاجة

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
