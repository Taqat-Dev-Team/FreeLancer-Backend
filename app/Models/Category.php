<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;
    public $translatable = ['name'];
    protected $fillable = ['name', 'icon'];

    public function subCategories() {
        return $this->hasMany(SubCategory::class);
    }

    public function freelancers() {
        return $this->hasMany(Freelancer::class);
    }

    public function skills() {
        return $this->hasMany(Skills::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }
}

