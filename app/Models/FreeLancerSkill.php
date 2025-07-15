<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreeLancerSkill extends Model
{
    protected $table = 'freelancers_skills';

    protected $fillable = [
        'freelancer_id',
        'skill_id',
    ];

    public function freelancer():BelongsTo
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function skill():BelongsTo
    {
        return $this->belongsTo(Skills::class);
    }
}
