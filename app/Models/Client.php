<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Client extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['user_id', 'website'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImagesUrls(): array
    {
        return $this->getMedia('images')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
            ];
        })->toArray();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
