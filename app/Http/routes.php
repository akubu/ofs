<?php


//reqquired if laravel is installed in a sub directory of main project
$base_url = config('app.rewrite_base');

Route::get($base_url . '/auth/login', 'Auth\AuthController@login');
Route::post($base_url . '/auth/vtiger/user', 'Auth\AuthController@validateVtigerUser');


Route::group(array('prefix' => 'api/v1'), function () {

    $base_url = config('app.rewrite_base');

    Route::get($base_url . 'runnerDetails/{id}', 'androidApi@runnerDetails');
    Route::get($base_url . 'getRunnerAllocations/{id}', 'androidApi@getRunnerAllocations');
    Route::get($base_url . 'getAttachedDevices/{id}', 'androidApi@getAttachedDevices');
    Route::get($base_url . 'deliver/{invoice1}/{invoice2}/{invoice3}/{invoice4}/{deviceId}/{comment}', 'androidApi@deliver');
    Route::get($base_url . 'getAttachedDevices/{id}', 'androidApi@getAttachedDevices');
    Route::get($base_url . 'attach/{vehicle_number}/{device_id}', 'androidApi@attach');
    Route::get($base_url . 'startTracking/{d1}/{d2}/{d3}/{d4}/{deviceId}/{runnerId}', 'androidApi@startTracking');
    Route::get($base_url . 'getLocation/{device_id}', "androidApi@getLocation");
    Route::get($base_url . 'getTrackingStatus', 'androidApi@getTrackingStatus');
    Route::get($base_url . 'getOrderLocation', 'androidApi@getOrderLocation');
    Route::post($base_url . 'runnerLocationSink', 'androidApi@runnerLocationSink');

});


$router->group(['middleware' => ['auth']], function () {
    $base_url = config('app.rewrite_base');
    Route::post($base_url . 'dc/documentUpload', 'dc@documentUpload');
});

$router->group(['middleware' => ['auth', 'actionLog']], function () {   ///'actionLog'

    $base_url = config('app.rewrite_base');

    Route::get($base_url . 'manageDc', 'dc@createForm');
    Route::get($base_url . 'autosuggest/so/undelivered', 'autosuggest@soUndelivered');
    Route::post($base_url . 'so/show', 'so@show');
    Route::post($base_url . 'so/checkExistence', 'so@exists');
    Route::get($base_url . 'so/test', 'so@test');

    Route::get($base_url . '/help/askForm', 'help@askForm');
    Route::get($base_url . '/help/question', 'help@question');


    Route::get($base_url . 'runner/validate', 'runner@validateRunner');
    Route::get($base_url . 'runner/create', 'runner@createForm');
    Route::post($base_url . 'runner/create', 'runner@create');
    Route::post($base_url . '/runner/updateSelect', 'runner@editForm');
    Route::get($base_url . '/runner/updateSelect', 'runner@editForm');
    Route::post($base_url . '/runner/update', 'runner@update');
    Route::get($base_url . '/runners', 'runner@index');
    Route::get($base_url . '/runner/delete', 'runner@deleteForm');
    Route::post($base_url . '/runner/delete', 'runner@destroy');
    Route::get($base_url . '/runner/all', 'runner@showAll');


    Route::get($base_url . 'track/currentDeviceLocation', 'trackDevice@currentDeviceLocation');


    Route::get($base_url . '/device/add', 'device@createForm');
    Route::post($base_url . '/device/add', 'device@create');
    Route::get($base_url . '/device/allocateForm', 'device@allocateForm');
    Route::post($base_url . '/device/allocate', 'device@allocate');
    Route::get($base_url . '/device/show/{id}', 'device@show');
    Route::get($base_url . '/device/recover', 'device@recoverForm');
    Route::post($base_url . '/device/recover', 'device@recover');
    Route::get($base_url . '/device/loss', 'device@lossForm');
    Route::post($base_url . '/device/loss', 'device@loss');
    Route::get($base_url . '/device/all', 'device@showAll');


    Route::post($base_url . 'dc/newDC', 'dc@newDC');
    Route::post($base_url . 'dc/getDCNumber', 'dc@generateDCNumber');
    Route::get($base_url . 'dc/showAll', 'dc@showAll');
    Route::get($base_url . 'dc/currentAssignments', 'dc@currentAssignments');
    Route::post($base_url . 'dc/create', 'dc@create');
    Route::get($base_url . 'dc/uploadDocuments', 'dc@uploadDocumentsSelectDC');
    Route::get($base_url . 'dc/documentsForDC', 'dc@documentsForDC');
    Route::get($base_url . 'dc/manageDC', 'dc@manageDC');
    Route::get($base_url . 'dc/updateForm', 'dc@updateForm');
    Route::get($base_url . 'dc/updateDCSelection', 'dc@updateDCSelection');
    Route::post($base_url . 'dc/update', 'dc@update');
    Route::get($base_url . 'dc/getDownload', 'dc@getDownload');
    Route::get($base_url . '/dc/markDeliveredSelection', 'dc@markDeliveredSelection');
    Route::get($base_url . '/dc/markDeliveredForm', 'dc@markDeliveredForm');
    Route::post($base_url . '/dc/markDelivered', 'dc@markDelivered');
    Route::post($base_url . '/dc/validateDCNumber/{dc_number}', 'dc@validateDCNumber');


    Route::get($base_url . 'home', 'panel@home');
    Route::get($base_url . '/', 'panel@index');


    Route::get($base_url . '/auth/logout', 'Auth\AuthController@logout');

});

