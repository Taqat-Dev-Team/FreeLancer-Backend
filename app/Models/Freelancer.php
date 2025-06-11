<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $fillable = [
        'user_id', 'cv', 'cv_view_count', 'category_id', 'sub_category_id', 'hourly_rate',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function educations()
    {
        return $this->hasMany(FreelancerEducation::class);
    }

    public function courses()
    {
        return $this->hasMany(FreelancerCourse::class);
    }

    public function portfolios()
    {
        return $this->hasMany(FreelancerPortfolio::class);
    }


    public function skills()
    {
        return $this->belongsToMany(Skills::class, 'freelancers_skills', 'freelancer_id', 'skill_id')
            ->withTimestamps();

    }

    public function socials()
    {
        return $this->belongsToMany(SocialMedia::class, 'free_lancer_social_media', 'freelancer_id', 'social_media_id')
            ->withPivot('link')
            ->withTimestamps();
    }

    public function badges()
    {
        return $this->belongsToMany(User::class, 'freelancer_badges', 'freelancer_id', 'badge_id');
    }

    public function images()
    {
        return $this->hasMany(FreelancerImages::class);
    }

    public function videos()
    {
        return $this->hasMany(FreelancerVideos::class);
    }

    public function socialMedia()
    {
        return $this->belongsToMany(SocialMedia::class, 'social_media_freelancer')
            ->withPivot('link');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
