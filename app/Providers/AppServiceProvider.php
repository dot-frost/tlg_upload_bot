<?php

namespace App\Providers;

use App\Services\Telegram\Bot;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Bot::class, function ($app) {
            return new Bot(
                config("tlg_bot.token"),
                config("tlg_bot.webhook"),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
