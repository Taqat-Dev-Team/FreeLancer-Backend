<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected $token;

    public function __construct($resource, $token = null)
    {
        parent::__construct($resource);
        $this->token = $token;
    }


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        $baseData = [
            'id' => $this->id,
            'token' => $this->token,
            'name' => $this->name,
            'photo' => $this->getImageUrl(),
            'email' => $this->email,
            'mobile' => $this->mobile,
            'country' => $this->country?->name,
            'birth_date' => $this->birth_date,
            'save_data' => $this->save_data,
//            'lang' => $this->lang,
//            'status' => $this->status,

            'bio' => $this->bio,
            'joined_date' => $this->created_at->format('d M, Y') . ' - ' . $this->created_at->diffForHumans(),
            'type' => $this->client ? 'client' : ($this->freelancer ? 'freelancer' : null),
        ];

        if ($this->client) {
            return $baseData;
        }

        if ($this->freelancer) {

            return array_merge($baseData, [
                'id_verified' => $this->freelancer->idVerified(),
                'cv_view_count' => $this->freelancer->cv_view_count,
                'category' => new CategoryResource($this->freelancer->category),
                'subCategory' => $this->freelancer->subCategory?->name,

                'hourly_rate' => $this->freelancer->hourly_rate,
                'available_hire' => $this->freelancer->available_hire,
                'experience' => $this->freelancer->experience,


                'skills' => $this->freelancer->skills->map(function ($skill) {
                    return [
                        'id' => $skill->id,
                        'name' => $skill->name,
                        'icon' => $skill->getImageUrl(),
                    ];
                }),

                'socials' => $this->freelancer->socials->map(function ($social) {
                    return [
                        'id' => $social->id,
                        'name' => $social->name,
                        'icon' => $social->icon,
                        'link' => $social->pivot->link,
                    ];
                }),

                'languages' => $this->freelancer->languages->map(function ($language) {
                    $levels = languages_levels();

                    return [
                        'id' => $language->id,
                        'name' => $language->name,
                        'level' => $levels[$language->pivot->level]['label'] ?? null,
                    ];
                }),


                'badges' => $this->freelancer->badges->map(function ($badge) {
                    return [
                        'id' => $badge->id,
                        'name' => $badge->name,
                        'icon' => $badge->getImageUrl(),
                        'description' => $badge->description,
                    ];
                }),

                'profile_complete' => $this->freelancer->profile_completion_status,


            ]);

        }

        return $baseData;
    }


}
