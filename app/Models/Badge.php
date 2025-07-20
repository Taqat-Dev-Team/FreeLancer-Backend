<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Badge extends Model implements HasMedia
{
    protected $fillable = ['name', 'description'];

    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name', 'description'];

    public function getImageUrl():string
    {
        return $this->getFirstMediaUrl('icon', 'thumb') ?: url('logos/favicon.png');
    }

    public function freelancers():BelongsToMany
    {
        return $this->belongsToMany(Freelancer::class, 'freelancer_badges', 'badge_id', 'freelancer_id');
    }


}
