<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Freelancer extends Model implements HasMedia

{

    use InteractsWithMedia;

    protected $fillable = [
        'user_id', 'cv', 'cv_view_count', 'category_id', 'sub_category_id', 'hourly_rate', 'available_hire',
    ];


    public function experience()
    {
        return 5;
    }

    public function getImagesUrls()
    {
        return $this->getMedia('images')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
//                 'name' => $media->name,
//                 'mime_type' => $media->mime_type,
//                 'size' => $media->size,
            ];
        })->toArray();
    }


    public function getProfileCompletionStatusAttribute()
    {
        $weights = [
            'summary' => 20,
            'skills' => 20,
            'employment_history' => 10,
            'languages' => 10,
            'portfolio' => 15,
            'social' => 5,
            'video_introduction' => 5,
            'profile_picture' => 10,
            'work_field' => 5,
        ];


        $details = [
            'summary' => __('profile_completion.summary_description'),
            'skills' => __('profile_completion.skills_description'),
            'employment_history'=> __('profile_completion.employment_history_description'),
            'languages' => __('profile_completion.languages_description'),
            'social' => __('profile_completion.social_description'),
            'portfolio'=> __('profile_completion.portfolio_description'),
            'video_introduction' => __('profile_completion.video_description'),
            'profile_picture' => __('profile_completion.picture_description'),
            'work_field' => __('profile_completion.work_field_description'),

        ];

        $checks = [

            'summary' => filled($this->user->bio)
                && filled($this->user->video)
                && $this->user->freelancer->hasMedia('images'),
            'skills' => $this->hasSkills(),
            'employment_history' => $this->hasEmployment(),
            'languages' => $this->hasLanguages(),
            'social' => $this->hasSocial(),
            'portfolio' => $this->hasPortfolio(),
            'video_introduction' => filled($this->video_introduction_url),
            'profile_picture' => filled($this->user->photo),
            'work_field' => filled($this->category_id),
        ];

        $earnedPoints = 0;
        $detailedStatus = [];

        foreach ($weights as $key => $weight) {
            $isCompleted = $checks[$key] ?? false;

            if ($isCompleted) {
                $earnedPoints += $weight;
            }

            $detailedStatus[] = [
                'id' => count($detailedStatus) + 1,
                'name' => __('profile_completion.' . $key),
                'is_completed' => $isCompleted,
                'description' => $details[$key] ?? '',
                'percentage' => $weight . '%',
            ];
        }

        $totalItems = count($weights);
        $completedItems = collect($checks)->filter()->count();
        $totalPoints = array_sum($weights);
        $percentage = $totalPoints ? round(($earnedPoints / $totalPoints) * 100) : 0;


        return [
            'completed_items' => $completedItems,
            'total_items' => $totalItems,
            'percentage' => $percentage,
            'completion_text' => __('profile_completion.text'),
            'status' => $detailedStatus,
        ];
    }

    public function hasSkills()
    {
        return $this->skills()->exists();

    }

    public function hasEmployment()
    {
        // For example, if employment entries are in a separate table:
//        return $this->employment()->exists();
        return false;
    }

    public function hasLanguages()
    {
        return $this->languages()->exists();
    }

    public function hasPortfolio()
    {
        // For example, if portfolio items are in a separate table:
//        return $this->portfolio()->exists();
        return true;
    }

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
        return $this->belongsToMany(Language::class, 'free_lancer_languages', 'freelancer_id', 'language_id')
            ->withPivot('level');

    }
}
