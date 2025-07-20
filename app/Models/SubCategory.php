<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{

    use HasTranslations;

    public $translatable = ['name','slug'];
    protected $fillable = ['category_id', 'name','slug'];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function freelancers():HasMany
    {
        return $this->hasMany(Freelancer::class);
    }
}
