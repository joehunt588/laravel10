<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
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
        //to remove "data" after UserResource
        JsonResource::withoutWrapping();

        \Gate::define("view", function (User $user, $model) {
            // return false;
            // dd($user);
            return $user->hasAccess("view_{$model}") || $user->hasAccess("edit_{$model}");
        });

        \Gate::define("edit", fn (User $user, $model) => $user->hasAccess("edit_{$model}"));
        // \Gate::define('edit', fn(User $user, $model) => $user->hasAccess("edit_{$model}"));
    }
}
