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
            'photo' => $this->getFirstMediaUrl('photo', 'thumb'),
            'email' => $this->email,
            'mobile' => $this->mobile,
            'country' => $this->country?->name,
            'birth_date' => $this->birth_date,
            'save_date'=> $this->save_date,
//            'lang' => $this->lang,
//            'status' => $this->status,

            'bio' => $this->bio,
            'type' => $this->client ? 'client' : ($this->freelancer ? 'freelancer' : null),
        ];

        if ($this->client) {
            return $baseData;
        }

        if ($this->freelancer) {
            return array_merge($baseData, [
                'cv_view_count' => $this->freelancer->cv_view_count,
                'category' => new CategoryResource($this->freelancer->category),
                'subCategory' => [
                    'name' => $this->freelancer->subCategory?->name,
                    'slug' => $this->freelancer->subCategory?->slug,
                ],
                'hourly_rate' => $this->freelancer->hourly_rate,
                'available_hire' => $this->freelancer->available_hire,
                'skills' =>
                    SkillsResource::collection($this->freelancer->skills),


            ]);
        }

        return $baseData;
    }

}
