<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Freelancer extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'hourly_rate',
        'available_hire',
        'review',
        'review_reason'
    ];

    protected $casts = [
        'available_hire' => 'boolean',
    ];

    // ----------------------------
    // Relationships
    // ----------------------------

    public function availability() :bool
    {
        // أولًا تحقق من وجود الهوية
        if (!$this->identityVerification) {
            return false;
        }

        // تحقق من حالة الهوية عبر خاصية label داخل دالة idVerified
        if (!$this->available_hire
            || $this->idVerified()->status !== '1'
            || !$this->user->status
            || $this->getProfileCompletionStatusAttribute()['percentage'] < setting('freelancers_availability_percentage')
        ) {
            return false;
        }

        return true;
    }

    public function availabilityDetails() :array
    {
        $reasons = [];

        if (!$this->available_hire) {
            $reasons[] = 'Freelancer has disabled hiring.';
        }

        if (!$this->identityVerification || $this->idVerified()->status !== '1') {
            $reasons[] = 'Identity not verified.';
        }

        if (!$this->user || !$this->user->status) {
            $reasons[] = 'User account is inactive.';
        }


        $status = $this->getProfileCompletionStatusAttribute();
        if ($status['percentage'] < setting('freelancers_availability_percentage')) {
            $reasons[] = 'Profile completion is below ' . setting('freelancers_availability_percentage') . '%.';
        }

        return $reasons;
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory() :BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function identityVerification(): HasOne
    {
        return $this->hasOne(IdentityVerification::class, 'freelancer_id')->latest();
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(FreelancerWorkExperience::class, 'freelancer_id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skills::class, 'freelancers_skills', 'freelancer_id', 'skill_id')
            ->withTimestamps();
    }


    public function educations(): HasMany
    {
        return $this->hasMany(FreelancerEducation::class);
    }


    public function portfolios(): HasMany
    {
        return $this->hasMany(FreelancerPortfolio::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(FreelancerSocial::class, 'freelancer_id')
            ->with('social');
    }

    public function languages(): HasMany
    {
        return $this->hasMany(FreeLancerLanguage::class, 'freelancer_id');
    }


    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'freelancer_badges', 'freelancer_id', 'badge_id');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }


    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function jobs(): int
    {
        return 0;
    }

    // ----------------------------
    // Helpers
    // ----------------------------

    public function getImagesUrls(): array
    {
        return $this->getMedia('images')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
                // 'name' => $media->name,
                // 'mime_type' => $media->mime_type,
                // 'size' => $media->size,
            ];
        })->toArray();
    }

    public function idVerified(): object
    {
        return (object)[
            'status' => $this->identityVerification->status ?? null,
            'label' => match ($this->identityVerification->status ?? null) {
                '0' => __('messages.pending'),
                '1' => __('messages.verified_id'),
                '2' => __('messages.rejected'),
                default => __('messages.notVerified'),
            },
        ];
    }

    // ----------------------------
    // Profile Completion Logic
    // ----------------------------

    public function getProfileCompletionStatusAttribute(): array
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
            'employment_history' => __('profile_completion.employment_history_description'),
            'languages' => __('profile_completion.languages_description'),
            'social' => __('profile_completion.social_description'),
            'portfolio' => __('profile_completion.portfolio_description'),
            'video_introduction' => __('profile_completion.video_description'),
            'profile_picture' => __('profile_completion.picture_description'),
            'work_field' => __('profile_completion.work_field_description'),
        ];

        $checks = [
            'summary' => filled($this->user->bio) && filled($this->user->video) && $this->hasMedia('images'),
            'skills' => $this->hasSkills(),
            'employment_history' => $this->hasWorkExperiences(),
            'languages' => $this->hasLanguages(),
            'social' => $this->hasSocial(),
            'portfolio' => $this->hasPortfolio(),
            'video_introduction' => filled($this->user->video),
            'profile_picture' => filled($this->user->getFirstMediaUrl('photo')),
            'work_field' => filled($this->category_id),
        ];

        $earnedPoints = 0;
        $detailedStatus = [];

        foreach ($weights as $key => $weight) {
            $completed = $checks[$key] ?? false;
            if ($completed) {
                $earnedPoints += $weight;
            }

            $detailedStatus[] = [
                'id' => count($detailedStatus) + 1,
                'name' => __('profile_completion.' . $key),
                'is_completed' => $completed,
                'description' => $details[$key] ?? '',
                'percentage' => $weight . '%',
            ];
        }

        $totalPoints = array_sum($weights);
        $percentage = $totalPoints ? round(($earnedPoints / $totalPoints) * 100) : 0;

        return [
            'completed_items' => collect($checks)->filter()->count(),
            'total_items' => count($weights),
            'percentage' => $percentage,
            'completion_text' => __('profile_completion.text'),
            'status' => $detailedStatus,
        ];
    }

    public function hasSkills(): bool
    {
        return $this->skills()->exists();
    }

    public function hasWorkExperiences(): bool
    {
        return $this->workExperiences()->exists();
    }

    public function hasLanguages(): bool
    {
        return $this->languages()->exists();
    }

    public function hasPortfolio(): bool
    {
        return $this->portfolios()->exists();
    }

    public function hasSocial(): bool
    {
        return $this->socialLinks()->exists();
    }

    public function getExperienceAttribute(): float
    {
        $totalMonths = 0;

        foreach ($this->workExperiences as $experience) {
            if (!$experience->start_date) {
                continue;
            }

            try {
                $start = Carbon::parse($experience->start_date);
                $end = $experience->end_date ? Carbon::parse($experience->end_date) : Carbon::now();

                if ($start->greaterThan($end)) {
                    continue;
                }

                $months = $start->diffInMonths($end);
                $totalMonths += $months;
            } catch (\Exception $e) {
                // تجاهل التواريخ غير الصحيحة
                continue;
            }
        }

        return round($totalMonths / 12, 1); // مثل 2.5 سنوات
    }

}
