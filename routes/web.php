<?php

/** @var \Illuminate\Routing\Router $router */

// Authentication routes
$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->get('login', 'LoginController@showLoginForm')->name('auth.login');
    $router->post('login', 'LoginController@login');
    $router->get('login/2fa', 'LoginController@showTwoFactorAuthenticationForm')->name('auth.twofactor');
    $router->post('login/2fa', 'LoginController@twoFactorAuthenticate');
    $router->post('logout', 'LoginController@logout')->name('auth.logout');

    // Password reset routes
    $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('auth.reset-password');
    $router->post('password/reset', 'ResetPasswordController@reset');
    $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('auth.reset-email');
    $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('auth.reset-confirm');
});

// Include the API routes inside an app path and add the authentication middleware to protect them
//$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'app'], function () use ($router) {
//    require base_path('routes/api.php');
//});

// Dashboard routes
$router->get('timeline', 'DashboardController@timeline')->middleware(['auth', 'jwt'])->name('dashboard.timeline');
$router->get('/', 'DashboardController@index')->middleware(['auth', 'jwt'])->name('dashboard');

// Administration
$router->group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => ['auth', 'jwt'],
], function () use ($router) {
    $router->resource('projects', 'ProjectController', [
        'only' => ['index', 'store', 'update', 'destroy'],
        'as' => 'admin',
    ]);

    $router->resource('users', 'UserController', [
        'only' => ['index', 'store', 'update', 'destroy'],
        'as' => 'admin',
    ]);

    $router->resource('groups', 'GroupController', [
        'only' => ['index', 'store', 'update'],
        'as' => 'admin',
    ]);
    $router->post('groups/reorder', 'GroupController@reorder')->name('admin.groups.reorder');

    $router->resource('templates', 'TemplateController', [
        'only' => ['index', 'store', 'update', 'destroy', 'show'],
        'as' => 'admin',
    ]);
    $router->get('templates/{id}/commands/{step}', 'TemplateController@listing')->name('admin.templates.commands.step');
});

// Deployments
$router->group([
    'middleware' => ['auth', 'jwt'],
], function () use ($router) {
    $router->get('webhook/{id}/refresh', 'WebhookController@refresh')->name('webhook.refresh');

    $router->get('projects/{id}', 'DeploymentController@project')->name('projects');
    $router->post('projects/{id}/deploy', 'DeploymentController@deploy')->name('projects.deploy');

    $router->get('deployment/{id}', 'DeploymentController@show')->name('deployments');
    $router->post('deployment/{id}/rollback', 'DeploymentController@rollback')->name('deployments.rollback');
    $router->get('deployment/{id}/abort', 'DeploymentController@abort')->name('deployments.abort');

    $router->get('log/{log}', 'DeploymentController@log')->name('deployments.log');
});

// User profile
$router->group([
    'middleware' => ['auth', 'jwt'],
    'as' => 'profile.',
], function () use ($router) {
    $router->get('profile', 'ProfileController@index')->name('index');
    $router->post('profile/update', 'ProfileController@update')->name('update');
    $router->post('profile/settings', 'ProfileController@settings')->name('settings');
    $router->post('profile/email', 'ProfileController@requestEmail')->name('request-change-email');
    $router->post('profile/upload', 'ProfileController@upload')->name('upload-avatar');
    $router->post('profile/avatar', 'ProfileController@avatar')->name('avatar');
    $router->post('profile/gravatar', 'ProfileController@gravatar')->name('gravatar');
    $router->post('profile/twofactor', 'ProfileController@twoFactor')->name('twofactor');
    $router->get('profile/email/{token}', 'ProfileController@email')->name('confirm-change-email');
    $router->post('profile/update-email', 'ProfileController@changeEmail')->name('change-email');
});
