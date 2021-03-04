<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Abstracts\PaymentRepositoryInterface;
use App\Repositories\Abstracts\UserRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        UserRepositoryInterface::class => UserRepository::class,
        PaymentRepositoryInterface::class => PaymentRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
