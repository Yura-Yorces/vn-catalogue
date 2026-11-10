<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\VisualNovel;
use App\Policies\UserPolicy;
use App\Policies\VisualNovelPolicy;

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
        //
        // Gate::define('access-mod-panel', fn (User $user) => $user->isStaff());
        // Gate::define('access-admin-panel', fn (User $user) => $user->isAdmin());
    }
}
