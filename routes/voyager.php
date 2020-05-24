<?php

Route::group(['as' => 'voyager.'], function () {
    $namespace = '\\Voyager\\Admin\\Http\\Controllers\\';

    Route::group(['middleware' => 'voyager.admin'], function () use ($namespace) {
        Route::view('/', 'voyager::voyager')->name('dashboard');
        Route::post('/', ['uses' => $namespace.'VoyagerController@data', 'as' => 'data']);
        Route::post('globalsearch', ['uses' => $namespace.'VoyagerController@globalSearch', 'as' => 'globalsearch']);

        // BREAD builder
        Route::group([
            'as'     => 'bread.',
            'prefix' => 'bread',
        ], function () use ($namespace) {
            Route::put('{table}', ['uses' => $namespace.'BreadBuilderController@update', 'as' => 'update']);
            Route::post('get-properties', ['uses' => $namespace.'BreadBuilderController@getProperties', 'as' => 'get-properties']);
            Route::post('get-breads', ['uses' => $namespace.'BreadBuilderController@getBreads', 'as' => 'get-breads']);
            Route::post('backup-bread', ['uses' => $namespace.'BreadBuilderController@backupBread', 'as' => 'backup-bread']);
            Route::post('rolback-bread', ['uses' => $namespace.'BreadBuilderController@rollbackBread', 'as' => 'rollback-bread']);
            Route::delete('{table}', ['uses' => $namespace.'BreadBuilderController@destroy', 'as' => 'delete']);
        });
        // BREADs
        foreach (resolve(\Voyager\Admin\Manager\Breads::class)->getBreads() as $bread) {
            $controller = $namespace.'BreadController';
            if (!empty($bread->controller)) {
                $controller = \Illuminate\Support\Str::start($bread->controller, '\\');
            }
            Route::group([
                'as'     => $bread->slug.'.',
                'prefix' => $bread->slug,
            ], function () use ($bread, $controller) {
                // Browse
                Route::post('/data', ['uses'=> $controller.'@data', 'as' => 'data', 'bread' => $bread]);
                // Edit
                Route::put('/{id}', ['uses' => $controller.'@update', 'as' => 'update', 'bread' => $bread]);
                // Add
                Route::post('/', ['uses' => $controller.'@store', 'as' => 'store', 'bread' => $bread]);
                // Delete
                Route::delete('/', ['uses' => $controller.'@delete', 'as' => 'delete', 'bread' => $bread]);
                Route::patch('/', ['uses' => $controller.'@restore', 'as' => 'restore', 'bread' => $bread]);
            });
        }

        // Settings
        Route::post('settings', ['uses' => $namespace.'SettingsController@store', 'as' => 'settings.store']);

        // Plugins
        Route::post('plugins/enable', ['uses' => $namespace.'PluginsController@enable', 'as' => 'plugins.enable']);
        Route::post('plugins', ['uses' => $namespace.'PluginsController@get', 'as' => 'plugins.get']);
        Route::post('plugins/install', ['uses' => $namespace.'PluginsController@install', 'as' => 'plugins.install']);

        // Logout
        Route::get('logout', ['uses' => $namespace.'AuthController@logout', 'as' => 'logout']);

        // Media
        Route::put('media', ['uses' => $namespace.'MediaController@uploadFile', 'as' => 'media.upload']);
        Route::post('media', ['uses' => $namespace.'MediaController@listFiles', 'as' => 'media.list']);
        Route::delete('media', ['uses' => $namespace.'MediaController@delete', 'as' => 'media.delete']);
        Route::post('create_folder', ['uses' => $namespace.'MediaController@createFolder', 'as' => 'media.create_folder']);

        //
        Route::post('get-disks', ['uses' => $namespace.'VoyagerController@getDisks', 'as' => 'get-disks']);
    });

    // Login
    Route::get('login', ['uses' => $namespace.'AuthController@login', 'as' => 'login']);
    Route::post('login', ['uses' => $namespace.'AuthController@processLogin', 'as' => 'login']);
    Route::post('forgot-password', ['uses' => $namespace.'AuthController@forgotPassword', 'as' => 'forgot_password']);

    // Asset routes
    Route::get('voyager-assets', ['uses' => $namespace.'VoyagerController@assets', 'as' => 'voyager_assets']);
});
