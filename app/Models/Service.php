<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'category_id',
        'sub_category_id',
        'file_format',
        'tags',
        'days',
        'revisions',
        'price',
        'add_ons',
        'requirements',
        'description',
        'questions',
        'freelancer_id'
    ];

    protected $casts = [
        'file_format' => 'array',
        'add_ons' => 'array',
        'requirements' => 'array',
        'questions' => 'array',
        'tags' => 'array',
    ];

    public function getCoverImageUrl()
    {
        $coverMedia = $this->getMedia('images')->first(function ($media) {
            return $media->getCustomProperty('is_cover') === true;
        });

        return $coverMedia ? [
            'id' => $coverMedia->id,
            'url' => $coverMedia->getFullUrl(),
            'is_cover' => true,
        ] : null;
    }


    public function getNonCoverImagesUrls()
    {
        return $this->getMedia('images')->filter(function ($media) {
            return $media->getCustomProperty('is_cover', false) === false;
        })->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
                'is_cover' => false,
            ];
        })->toArray();
    }


    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}



