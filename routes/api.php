<?php

Route::prefix('v1')->group(function () {

    /**** Auth ****/
    Route::namespace('API\v1\Auth')->group(function () {
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        // Route::post('token/refresh', 'LoginController@refresh');
        Route::post('register', 'RegistrationController@register');
        Route::post('forgot-password', 'ForgotPasswordController@sendResetLink');
        Route::post('reset-password', 'ForgotPasswordController@resetPassword');

        Route::get('verify-email', 'VerificationController@verifyEmail')->name('verification.verify');
        Route::post('verify-email', 'VerificationController@sendVerificationEmail');
    });

    /**** User ****/
    Route::namespace('API\v1\User')->group(function () {
        Route::get('users', 'UserController@list');
        Route::get('users/{user}', 'UserController@details');
        Route::get('profile', 'UserController@profile');
        Route::patch('profile', 'UserController@updateProfile');
        Route::patch('users/{user}', 'UserController@update');

        Route::patch('users/{user}/avatar', 'UserController@uploadUserAvatar');
        Route::patch('profile/avatar', 'UserController@uploadProfileAvatar');
    });

    /**** UserGroup ****/
    Route::namespace('API\v1\UserGroup')->group(function () {
        
        Route::get('usergroups', 'UserGroupController@list');
        Route::get('usergroups/{userGroup}', 'UserGroupController@details');
        Route::post('usergroups', 'UserGroupController@create');
        Route::post('usergroups/exists', 'UserGroupController@exists');
        Route::patch('usergroups/{userGroup}', 'UserGroupController@update');
        Route::delete('usergroups/{userGroup}', 'UserGroupController@delete');
    });

    /**** SystemSettings ****/
    Route::namespace('API\v1\SystemSetting')->group(function () {
        Route::get('systemsettings', 'SystemSettingController@list');
        Route::get('systemsettings/allowpublicregistration', 'SystemSettingController@allowPublicRegistration');
        Route::patch('systemsettings', 'SystemSettingController@update');
    });

    /**** SystemSettings ****/
    Route::namespace('API\v1\Announcement')->group(function () {
        Route::get('announcements', 'AnnouncementController@list');
        Route::get('announcements/{announcement}', 'AnnouncementController@details');
        Route::post('announcements', 'AnnouncementController@create');
        Route::patch('announcements/{announcement}', 'AnnouncementController@update');
        Route::delete('announcements/{announcement}', 'AnnouncementController@delete');
    });

    /**** Permissions ****/
    Route::namespace('API\v1\Permission')->group(function () {
        Route::get('permissions', 'PermissionController@list');
    });

    /**** Products ****/
     Route::namespace('API\v1\Product')->group(function () {
        Route::get('products', 'ProductController@list');
        Route::get('products/{product}', 'ProductController@details');
        Route::post('products', 'ProductController@create');
        Route::patch('products/{product}', 'ProductController@update');
        Route::delete('products/{product}', 'ProductController@delete');
    });

    /**** Contacts ****/
    Route::namespace('API\v1\Contact')->group(function () {
        Route::get('contacts', 'ContactController@list');
        Route::get('contacts/{contact}', 'ContactController@details');
    });

    /**** Orders ****/
    Route::namespace('API\v1\Order')->group(function () {
        Route::get('orders', 'OrderController@list');
        Route::get('orders/statistics', 'OrderController@statistics');
        Route::get('orders/badges', 'OrderController@badges');
        Route::get('orders/{order}', 'OrderController@details');

        Route::post('orders/{order}/workitem', 'OrderController@submit_work_item');
    });

});
