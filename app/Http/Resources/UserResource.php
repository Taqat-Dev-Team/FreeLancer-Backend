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
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'mobile'  => $this->mobile,
            'country' => new  CountryResource($this->country),
            'lang'   => $this->lang,
            'status' => $this->status,
            'token'  => $this->token,
            'bio'  => $this->bio,
            'type'   => $this->client ? 'client' : 'freelancer',
        ];

        if ($this->client) {
            return $baseData;
        }

        if ($this->freelancer) {
            return array_merge($baseData, [
                'cv_view_count' => $this->freelancer->cv_view_count,
                'category'      => new CategoryResource($this->freelancer->category),
                'subCategory'   => new SubCategoryResource($this->freelancer->subCategory),
            ]);
        }

        return $baseData;
    }

}
