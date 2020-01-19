<?php
namespace App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('App\Repositories\Auth\OAuthRepositoryInterface', 'App\Repositories\Auth\OAuthRepository');
        $this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\UserGroup\UserGroupRepositoryInterface', 'App\Repositories\UserGroup\UserGroupRepository');
    }
}