<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasTranslations , InteractsWithMedia;

    public $translatable = ['name','slug'];
    protected $fillable = ['name', 'icon'];


    public function getImageUrl()
    {
        return $this->getFirstMediaUrl('icon') ?: url('logos/favicon.png');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function freelancers()
    {
        return $this->hasMany(Freelancer::class);
    }

    public function skills()
    {
        return $this->hasMany(Skills::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getImage()
    {
        return $this->icon ? asset('storage/' . $this->icon) : asset('logos/favicon.png');
    }
}

