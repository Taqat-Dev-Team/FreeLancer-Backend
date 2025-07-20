<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name', 'slug'];
    protected $fillable = ['name', 'icon'];


    public function getImageUrl():string
    {
        return $this->getFirstMediaUrl('icon','thumb') ?: url('logos/favicon.png');
    }


    public function subCategories():HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function freelancers():HasMany
    {
        return $this->hasMany(Freelancer::class);
    }

    public function skills():HasMany
    {
        return $this->hasMany(Skills::class);
    }

    public function projects():HasMany
    {
        return $this->hasMany(Project::class);
    }


}

