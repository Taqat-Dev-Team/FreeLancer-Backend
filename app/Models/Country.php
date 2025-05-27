<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;
    protected $fillable = ['name', 'code', 'number_code'];

    public $timestamps = false;

    public $translatable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
