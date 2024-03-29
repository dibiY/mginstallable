<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'install', 'as' => 'mginstallable::', 'namespace' => 'Dibiy\MgInstallable\Controllers', 'middleware' => ['web', 'install']], function () {
    
    Route::get('/', [
        'as' => 'welcome',
        'uses' => 'WelcomeController@welcome',
    ]);

    Route::get('license', [
        'as' => 'checkLicenseForm',
        'uses' => 'CheckLicenseController@checkLicenseForm',
    ]);

    Route::post('license', [
        'as' => 'checkLicense',
        'uses' => 'CheckLicenseController@checkLicencseKey',
    ]);

    Route::get('environment', [
        'as' => 'environment',
        'uses' => 'EnvironmentController@environmentMenu',
    ]);

    Route::get('environment/wizard', [
        'as' => 'environmentWizard',
        'uses' => 'EnvironmentController@environmentWizard',
    ]);

    Route::post('environment/saveWizard', [
        'as' => 'environmentSaveWizard',
        'uses' => 'EnvironmentController@saveWizard',
    ]);

    Route::get('environment/classic', [
        'as' => 'environmentClassic',
        'uses' => 'EnvironmentController@environmentClassic',
    ]);

    Route::post('environment/saveClassic', [
        'as' => 'environmentSaveClassic',
        'uses' => 'EnvironmentController@saveClassic',
    ]);

    Route::get('requirements', [
        'as' => 'requirements',
        'uses' => 'RequirementsController@requirements',
    ]);

    Route::get('permissions', [
        'as' => 'permissions',
        'uses' => 'PermissionsController@permissions',
    ]);

    Route::get('database', [
        'as' => 'database',
        'uses' => 'DatabaseController@database',
    ]);

    Route::get('final', [
        'as' => 'final',
        'uses' => 'FinalController@finish',
    ]);
});

Route::group(['prefix'=>'update-license', 'as' => 'LicenseUpdater::', 'namespace' => 'Dibiy\MgInstallable\Controllers', 'middleware' => ['web', 'updateLicense']],function(){
    Route::group(['middleware' => 'update-license'], function () {
        Route::get('/',[
            'as' => 'update-license.form',
            'uses' => 'UpdateLicenseController@formUpdateLicense'
        ]);
        Route::post('/',[
            'as' => 'update-license.check_update_license',
            'uses' => 'UpdateLicenseController@updateCheckLicense'
        ]);
        Route::get('/final',[
            'as' => 'update-license.final',
            'uses' => 'UpdateLicenseController@finish'
        ]);
    });
});

Route::group(['prefix' => 'update', 'as' => 'LaravelUpdater::', 'namespace' => 'Dibiy\MgInstallable\Controllers', 'middleware' => 'web'], function () {
    Route::group(['middleware' => 'update'], function () {
        Route::get('/', [
            'as' => 'welcome',
            'uses' => 'UpdateController@welcome',
        ]);

        Route::get('overview', [
            'as' => 'overview',
            'uses' => 'UpdateController@overview',
        ]);

        Route::get('database', [
            'as' => 'database',
            'uses' => 'UpdateController@database',
        ]);
    });

    // This needs to be out of the middleware because right after the migration has been
    // run, the middleware sends a 404.
    Route::get('final', [
        'as' => 'final',
        'uses' => 'UpdateController@finish',
    ]);
});
