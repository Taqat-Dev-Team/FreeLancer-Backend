<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeLancerLanguage extends Model
{
    protected $table = 'free_lancer_languages'; // اسم جدول العلاقة

    public $timestamps = false;

    protected $fillable = ['freelancer_id', 'level','language_id'];


    public function lang()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
