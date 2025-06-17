<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $fillable = [
        'user_id', 'cv', 'cv_view_count', 'category_id', 'sub_category_id', 'hourly_rate','available_hire','experience'
    ];


    public function getProfileCompletionStatusAttribute()
    {
        // الأوزان لكل عنصر
        $weights = [
            'summary'            => 10,
            'skills'             => 10,
            'languages'          => 5,
            'social'             => 5,
            'video_introduction' => 10,
            'profile_picture'    => 15,
            'work_field'         => 10,
        ];

        // وصف ونقاط كل عنصر
        $details = [
            'summary' => 'Tell us more about your skills, work experience, and what makes you stand out.',
            'skills' => 'Select key skills to help us recommend the right projects.',
            'languages' => 'Add the languages you speak and your level.',
            'social' => 'Connect your social profiles like LinkedIn, GitHub, or Behance.',
            'video_introduction' => 'Upload a short video to introduce yourself and stand out.',
            'profile_picture' => 'Show your clients who they\'re working with.',
            'work_field' => 'Choose your main work category and a relevant subcategory.',
        ];

        // شروط التحقق من الاكتمال
        $checks = [
            'summary'            => !empty($this->user->bio),
            'skills'             => $this->hasSkills(),
            'languages'          => $this->hasLanguages(),
            'social'             => $this->hasSocial(),
            'video_introduction' => !empty($this->video_introduction_url),
            'profile_picture'    => !empty($this->user->photo),
            'work_field'         => !empty($this->category_id),
        ];

        $earnedPoints = 0;
        $detailedStatus = [];
        $totalPoints = array_sum($weights);
        $completedItems = 0;

        foreach ($weights as $key => $point) {
            $isCompleted = $checks[$key] ?? false;

            if ($isCompleted) {
                $earnedPoints += $point;
                $completedItems++;
            }

            $detailedStatus[] = [
                'id'           => count($detailedStatus) + 1,
                'name'         => ucwords(str_replace('_', ' ', $key)),
                'is_completed' => $isCompleted,
                'description'  => $details[$key] ?? '',
                'percentage'   => "{$point}%",
            ];
        }

        return [
            'completed_items' => $completedItems,
            'total_items'     => count($weights),
            'percentage'      => $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0,
            'status'          => $detailedStatus,
        ];
    }
    public function hasSkills()
    {
        return $this->skills()->exists();

    }

//    public function hasEmployment()
//    {
//        // For example, if employment entries are in a separate table:
//        return $this->employment()->exists();
//    }

    public function hasLanguages()
    {
        return $this->languages()->exists();
    }

//    public function hasPortfolio()
//    {
//        // For example, if portfolio items are in a separate table:
//        return $this->portfolio()->exists();
//    }

    public function hasSocial()
    {
        // For example, if social links are stored as JSON in 'social_links' column:
        return $this->socials()->exists();
    }

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
            ->withPivot('link');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'freelancer_badges', 'freelancer_id', 'badge_id');
    }


    public function images()
    {
        return $this->hasMany(FreelancerImages::class);
    }

    public function videos()
    {
        return $this->hasMany(FreelancerVideos::class);
    }


    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function idVerified()
    {
        return true;
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'free_lancer_languages','freelancer_id','language_id')
            ->withPivot('level');

    }
}
