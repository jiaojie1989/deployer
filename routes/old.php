<?php

// FIXME: Still be be converted!

// User profile
Route::group([
    'middleware' => ['web', 'auth', 'jwt'],
], function () {
    Route::get('profile', [
        'as'   => 'profile.index',
        'uses' => 'ProfileController@index',
    ]);

    Route::post('profile/update', [
        'as'   => 'profile.update',
        'uses' => 'ProfileController@update',
    ]);

    Route::post('profile/settings', [
        'as'   => 'profile.settings',
        'uses' => 'ProfileController@settings',
    ]);

    Route::post('profile/email', [
        'as'   => 'profile.request-change-email',
        'uses' => 'ProfileController@requestEmail',
    ]);

    Route::post('profile/upload', [
        'as'   => 'profile.upload-avatar',
        'uses' => 'ProfileController@upload',
    ]);

    Route::post('profile/avatar', [
        'as'   => 'profile.avatar',
        'uses' => 'ProfileController@avatar',
    ]);

    Route::post('profile/gravatar', [
        'as'   => 'profile.gravatar',
        'uses' => 'ProfileController@gravatar',
    ]);

    Route::post('profile/twofactor', [
        'as'   => 'profile.twofactor',
        'uses' => 'ProfileController@twoFactor',
    ]);

    Route::get('profile/email/{token}', [
        'as'   => 'profile.confirm-change-email',
        'uses' => 'ProfileController@email',
    ]);

    Route::post('profile/update-email', [
        'as'   => 'profile.change-email',
        'uses' => 'ProfileController@changeEmail',
    ]);
});



// Deployments
Route::group([
    'middleware' => ['web', 'auth', 'jwt'],
], function () {
    Route::get('webhook/{id}/refresh', [
        'as'   => 'webhook.refresh',
        'uses' => 'WebhookController@refresh',
    ]);

    Route::get('projects/{id}', [
        'as'   => 'projects',
        'uses' => 'DeploymentController@project',
    ]);

    Route::post('projects/{id}/deploy', [
        'as'   => 'projects.deploy',
        'uses' => 'DeploymentController@deploy',
    ]);

    Route::post('deployment/{id}/rollback', [
        'as'   => 'deployments.rollback',
        'uses' => 'DeploymentController@rollback',
    ]);

    Route::get('deployment/{id}/abort', [
        'as'   => 'deployments.abort',
        'uses' => 'DeploymentController@abort',
    ]);

    Route::get('deployment/{id}', [
        'as'   => 'deployments',
        'uses' => 'DeploymentController@show',
    ]);

    Route::get('log/{log}', [
        'as'   => 'deployments.log',
        'uses' => 'DeploymentController@log',
    ]);
});

// User profile
Route::group([
    'middleware' => ['web', 'auth', 'jwt'],
], function () {
    Route::get('profile', [
        'as'   => 'profile.index',
        'uses' => 'ProfileController@index',
    ]);

    Route::post('profile/update', [
        'as'   => 'profile.update',
        'uses' => 'ProfileController@update',
    ]);

    Route::post('profile/settings', [
        'as'   => 'profile.settings',
        'uses' => 'ProfileController@settings',
    ]);

    Route::post('profile/email', [
        'as'   => 'profile.request-change-email',
        'uses' => 'ProfileController@requestEmail',
    ]);

    Route::post('profile/upload', [
        'as'   => 'profile.upload-avatar',
        'uses' => 'ProfileController@upload',
    ]);

    Route::post('profile/avatar', [
        'as'   => 'profile.avatar',
        'uses' => 'ProfileController@avatar',
    ]);

    Route::post('profile/gravatar', [
        'as'   => 'profile.gravatar',
        'uses' => 'ProfileController@gravatar',
    ]);

    Route::post('profile/twofactor', [
        'as'   => 'profile.twofactor',
        'uses' => 'ProfileController@twoFactor',
    ]);

    Route::get('profile/email/{token}', [
        'as'   => 'profile.confirm-change-email',
        'uses' => 'ProfileController@email',
    ]);

    Route::post('profile/update-email', [
        'as'   => 'profile.change-email',
        'uses' => 'ProfileController@changeEmail',
    ]);
});

// Administration
Route::group([
    'middleware' => ['web', 'auth', 'jwt'],
    'prefix'     => 'admin',
    'namespace'  => 'Admin',
], function () {
    Route::resource('templates', 'TemplateController', [
        'only' => ['index', 'store', 'update', 'destroy', 'show'],
    ]);

    Route::resource('projects', 'ProjectController', [
        'only' => ['index', 'store', 'update', 'destroy'],
    ]);

    Route::resource('users', 'UserController', [
        'only' => ['index', 'store', 'update', 'destroy'],
    ]);

    Route::resource('groups', 'GroupController', [
        'only' => ['index', 'store', 'update'],
    ]);

    Route::post('groups/reorder', [
        'as'    => 'admin.groups.reorder',
        'uses'  => 'GroupController@reorder',
    ]);

    Route::get('admin/templates/{id}/commands/{step}', [
        'as'   => 'admin.templates.commands.step',
        'uses' => 'TemplateController@listing',
    ]);
});
