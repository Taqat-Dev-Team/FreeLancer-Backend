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
            'country' => new CountryResource($this->country),
            'birth_date' => $this->birth_date,
            'save_data' => $this->save_data,
            'joined_date' => $this->created_at->format('d M, Y') . ' , ' . $this->created_at->diffForHumans(),
            'type' => $this->client ? 'client' : ($this->freelancer ? 'freelancer' : null),
        ];

        if ($this->client) {
            return $baseData;
        }

        if ($this->freelancer) {

            return array_merge($baseData, [
                'id_verified' => $this->freelancer->idVerified(),
                'category' => new CategoryResource($this->freelancer->category),
                'sub_category' => new SubCategoryResource($this->freelancer->subCategory),

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

                'socials' => $this->freelancer->socialLinks()->with('social')->get()->map(function ($item) {
                    return [
                        'id' => $item->social_media_id,
                        'name' => $item->social?->name ?? $item->title,
                        'icon' => $item->social->icon ?? '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.99935 18.3334C14.6017 18.3334 18.3327 14.6025 18.3327 10.0001C18.3327 5.39771 14.6017 1.66675 9.99935 1.66675C5.39698 1.66675 1.66602 5.39771 1.66602 10.0001C1.66602 14.6025 5.39698 18.3334 9.99935 18.3334Z" stroke="#696A70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6.66667 2.5H7.5C5.875 7.36667 5.875 12.6333 7.5 17.5H6.66667" stroke="#696A70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12.5 2.5C14.125 7.36667 14.125 12.6333 12.5 17.5" stroke="#696A70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M2.5 13.3333V12.5C7.36667 14.125 12.6333 14.125 17.5 12.5V13.3333" stroke="#696A70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M2.5 7.5C7.36667 5.875 12.6333 5.875 17.5 7.5" stroke="#696A70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
',

                        'link' => $item->link,
                    ];
                }),

                'languages' => $this->freelancer->languages()->with('lang')->get()->map(function ($item) {
                    $level = languages_levels()->firstWhere('id', $item->level);
                    return [
                        'id' => $item->language_id,
                        'name' => $item->lang?->name,
                        'level' => $item->level,
                        'level_name' => $level ? $level['label'] : null,
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


            ]);

        }

        return $baseData;
    }


}
