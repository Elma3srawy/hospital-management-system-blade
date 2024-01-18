<?php

namespace App\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\ProfileImage\ProfileImageServices;




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
        JsonResource::withoutWrapping();
        // $image_path = (new ProfileImageServices)->ProfileImage();
        // View::share('image_path', $image_path);
    }
}
