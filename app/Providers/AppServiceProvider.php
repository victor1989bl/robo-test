<?php

namespace App\Providers;

use App\Services\Abstracts\PaymentServiceInterface;
use App\Services\Abstracts\UserServiceInterface;
use App\Services\PaymentService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class AppServiceProvider extends ServiceProvider
{
    protected $services = [
        UserServiceInterface::class => UserService::class,
        PaymentServiceInterface::class => PaymentService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('ru_RU');
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
