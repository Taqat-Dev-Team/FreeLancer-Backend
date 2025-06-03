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
            'name' => $this->name,
            'photo' => $this->getFirstMediaUrl('photo', 'thumb'),
            'email' => $this->email,
            'mobile' => $this->mobile,
            'country' => new  CountryResource($this->country),
//            'lang'   => $this->lang,
            'status' => $this->status,
            'token' => $this->token,
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
            ]);
        }

        return $baseData;
    }

}
