<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Html\Editor\Fields\BelongsTo;

class FreelancerWorkExperience extends Model
{
    protected $table = 'freelancer_work_experiences';
    protected $fillable = ['freelancer_id', 'company_name', 'title', 'location', 'type', 'start_date', 'end_date', 'description'];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function getDurationAttribute(): string
    {
        if ($this->end_date) {
            return round($this->start_date->diffInRealYears($this->end_date ?? now()));

        }
        return round($this->start_date->diffInYears(now()));
    }

    public function getFormattedStartDateAttribute(): string
    {
        return Carbon::parse($this->start_date)->translatedFormat('F Y');
    }


    public function getFormattedEndDateAttribute(): string
    {
        return $this->end_date ? Carbon::parse($this->end_date)->translatedFormat('F Y') : __('messages.Present');
    }


}
