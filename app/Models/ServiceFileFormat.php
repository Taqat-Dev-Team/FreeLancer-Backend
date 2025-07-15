<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceFileFormat extends Model
{
    use HasTranslations;

    protected $table = 'service_file_formats';

    protected $guarded = ['category_id', 'name'];

    public $translatable = ['name'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_formats', 'format_id', 'service_id')
            ->withTimestamps();

    }
}
