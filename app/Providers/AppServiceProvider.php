<?php

namespace App\Providers;

use App\Models\Badge;
use App\Models\Category;
use App\Models\Skills;
use App\Observers\MediaObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(MediaObserver::class);
        Skills::observe(MediaObserver::class);
        Badge::observe(MediaObserver::class);

        Model::automaticallyEagerLoadRelationships();

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
