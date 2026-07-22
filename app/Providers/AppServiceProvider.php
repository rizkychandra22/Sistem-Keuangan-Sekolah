<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Message;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;

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
    public function boot()
    {
        Route::singularResourceParameters(false);

        Paginator::useBootstrapFive();
        
        view()->composer('*', function ($view) {
            $unreadCount = Message::where('is_read', false)->count();
            $view->with('unreadCount', $unreadCount);
        });
    }

}
