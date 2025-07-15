<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Skills extends Model implements HasMedia
{


    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name'];
    protected $fillable = ['name', 'category_id', 'icon'];


    public function getImageUrl():string
    {
        return $this->getFirstMediaUrl('icon', 'thumb') ?: url('logos/favicon.png');
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function freeLancer():HasMany
    {
        return $this->belongsToMany(Freelancer::class, 'freelancers_skills', 'skill_id', 'freelancer_id')
            ->withTimestamps();

    }
}

