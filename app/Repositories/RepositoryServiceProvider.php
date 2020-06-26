<?php
namespace App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('App\Repositories\Auth\OAuthRepositoryInterface', 'App\Repositories\Auth\OAuthRepository');
        $this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\UserGroup\UserGroupRepositoryInterface', 'App\Repositories\UserGroup\UserGroupRepository');
        $this->app->bind('App\Repositories\SystemSetting\SystemSettingRepositoryInterface', 'App\Repositories\SystemSetting\SystemSettingRepository');
        $this->app->bind('App\Repositories\Announcement\AnnouncementRepositoryInterface', 'App\Repositories\Announcement\AnnouncementRepository');

        $this->app->bind('App\Repositories\Product\IProductRepository', 'App\Repositories\Product\ProductRepository');
        $this->app->bind('App\Repositories\Order\IOrderRepository', 'App\Repositories\Order\OrderRepository');

        $this->app->bind('App\Repositories\Contact\IContactRepository', 'App\Repositories\Contact\ContactRepository');
    }
}