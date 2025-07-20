<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Yajra\DataTables\Html\Editor\Fields\BelongsTo;

class SocialMedia extends Model
{
    Use HasTranslations;
    protected $fillable = [
        'name',
        'icon',
    ];

    public $translatable = ['name'];
    public function freeLancer():BelongsTo
    {
        return $this->belongsToMany(Freelancer::class, 'free_lancer_social_media')
            ->withPivot(['link','title'])
            ->withTimestamps();
    }
}
