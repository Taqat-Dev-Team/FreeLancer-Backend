<?php

namespace App\Http\Controllers\Front\FreeLancer;

use App\Http\Controllers\Controller;
use App\ApiResponseTrait;
use App\Http\Requests\Front\Freelancer\EducationRequest;
use App\Http\Requests\Front\Freelancer\ServiceRequest;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            $education = Auth::user()->freelancer->services()->latest()->get();

            return $this->apiResponse(
                ServiceResource::collection($education),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error fetching Service: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public function store(ServiceRequest $request)
    {
        {
            DB::beginTransaction();
            try {
                $data = $request->validated();

                // تجهيز البيانات للموديل
                $serviceData = [
                    'title' => $data['title'],
                    'category_id' => $data['category_id'] ?? null,
                    'sub_category_id' => $data['sub_category_id'] ?? null,
                    'file_format' => $data['file_format'] ?? [],
                    'tags' => implode(',', $data['tags'] ?? []), // تحويل المصفوفة إلى string إذا كان الحقل ليس casted as array
                    'days' => $data['days'],
                    'revisions' => $data['revisions'],
                    'price' => $data['price'],
                    'add_ons' => $data['add_ons'] ?? [],
                    'freelancer_id' => $data['freelancer_id'],
                    // البيانات من قسم "Description"
                    'description' => $data['description_summary'], // هذا هو "Project summary"
                    // البيانات من قسم "Process" (Requirements)
                    'requirements' => $data['requirements'] ?? [], // هذا هو "Info you'll need from the client"
                    // البيانات من "Frequently asked questions" (تقابل 'questions' في الموديل)
                    'questions' => $data['faqs'] ?? [],
                ];

                $service = Service::create($serviceData);


                if ($request->hasFile('images')) {
                    $coverImageIndex = $data['cover_image_index'];
                    $mediaCollection = [];

                    foreach ($request->file('images') as $index => $imageFile) {
                        $media = $service->addMedia($imageFile)->toMediaCollection('images'); // 'images' هو اسم المجموعة
                        $mediaCollection[] = $media;
                        // تعيين خاصية مخصصة لتمييز صورة الغلاف
                        if ($index == $coverImageIndex) {
                            $media->setCustomProperty('is_cover', true)->save();
                        }
                    }
                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Service created successfully',
                    'data' => $service
                ], 201);
            } catch
            (\Throwable $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }
    }


    public
    function show($id)
    {
        try {
            $education = Auth::user()->freelancer->educations()->find($id);

            if (!$education) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            return $this->apiResponse(
                new EducationResource($education),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error fetching work education: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }

    public
    function update(EducationRequest $request, $id)
    {
        try {
            $education = Auth::user()->freelancer->educations()->find($id);

            if (!$education) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            $data = $this->formatDates($request->validated());
            $education->update($data);

            return $this->apiResponse(
                new EducationResource($education),
                __('messages.success'),
                true,
                200
            );
        } catch (\Throwable $e) {
            Log::error('Error updating  educations : ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }


    public
    function destroy($id)
    {
        try {
            $education = Auth::user()->freelancer->educations()->find($id);

            if (!$education) {
                return $this->apiResponse([], __('messages.not_found'), false, 404);
            }

            $education->delete();

            return $this->apiResponse([], __('messages.success'), true, 200);
        } catch (\Throwable $e) {
            Log::error('Error deleting work experience: ' . $e->getMessage());
            return $this->apiResponse([], __('messages.error'), false, 500);
        }
    }


}
