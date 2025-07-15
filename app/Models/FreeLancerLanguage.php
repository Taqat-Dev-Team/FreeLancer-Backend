<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreeLancerLanguage extends Model
{
    protected $table = 'free_lancer_languages'; // اسم جدول العلاقة

    public $timestamps = false;

    protected $fillable = ['freelancer_id', 'level','language_id'];


    public function lang():BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
