<?php


//reqquired if laravel is installed in a sub directory of main project
$base_url = config('app.rewrite_base');
Route::get($base_url . '/auth/login', 'Auth\AuthController@login');
Route::post($base_url . '/auth/vtiger/user', 'Auth\AuthController@validateVtigerUser');

//keep this route out of auth area.
Route::get($base_url . '/api/features/{id?}/{force_api?}', 'Api\FeatureController@get');


Route::group(array('prefix' => '/webApp'), function () {

        Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'webApp@index');
    Route::get('/startLoading', 'webApp@startLoading');
    Route::get('/dispatch', 'webApp@dispatchIt');
    Route::get('/deliver', 'webApp@deliver');
    Route::get('/track', 'webApp@track');


});
});



Route::group(array('prefix' => 'api/v1'), function () {




        Route::get('runnerDetails/{id}', 'androidApi@runnerDetails');
        Route::get('getRunnerAllocations/{id}', 'androidApi@getRunnerAllocations');
        Route::get('getAttachedDevices/{id}', 'androidApi@getAttachedDevices');
        Route::get('deliver/{invoice1}/{invoice2}/{invoice3}/{invoice4}/{deviceId}/{comment}', 'androidApi@deliver');
        Route::get('getAttachedDevices/{id}', 'androidApi@getAttachedDevices');
        Route::get('attach/{vehicle_number}/{device_id}', 'androidApi@attach');
        Route::get('startTracking/{d1}/{d2}/{d3}/{d4}/{deviceId}/{runnerId}', 'androidApi@startTracking');
        Route::get('getLocation/{device_id}', "androidApi@getLocation");
        Route::get('getTrackingStatus', 'androidApi@getTrackingStatus');
        Route::get('getOrderLocation', 'androidApi@getOrderLocation');

    Route::post('runnerLocationSink', 'androidApi@runnerLocationSink');

    });


$router->group(['middleware' => ['auth']], function () {   ///'actionLog'


    $base_url = config('app.rewrite_base');

    //all direct request


    Route::get('manageDc', 'dc@createForm');
    Route::get('autosuggest/so/undelivered', 'autosuggest@soUndelivered');
    Route::post('so/show', 'so@show');
    Route::post('so/checkExistence', 'so@exists');
    Route::get('so/test', 'so@test');
    Route::get('/help/askForm', 'help@askForm');
    Route::get('/help/question', 'help@question');


    Route::get('runner/validate', 'runner@validateRunner');


    Route::get('runner/create', 'runner@createForm');
    Route::post('runner/create', 'runner@create');

    Route::post('/runner/updateSelect', 'runner@editForm');
    Route::get('/runner/updateSelect', 'runner@editForm');
    Route::post('/runner/update', 'runner@update');
    Route::get('/runners', 'runner@index');
    Route::get('/runner/delete', 'runner@deleteForm');
    Route::post('/runner/delete', 'runner@destroy');
    Route::get('/runner/all', 'runner@showAll');


//    Route::get('/track/runner', 'trackDevice@runner');
    Route::get('track/currentDeviceLocation', 'trackDevice@currentDeviceLocation');


    Route::get('/device/add', 'device@createForm');
    Route::post('/device/add', 'device@create');

    Route::get('/device/allocateForm', 'device@allocateForm');
    Route::post('/device/allocate', 'device@allocate');

    Route::get('/device/show/{id}', 'device@show');
    Route::get('/device/recover', 'device@recoverForm');
    Route::post('/device/recover', 'device@recover');
    Route::get('/device/loss', 'device@lossForm');
    Route::post('/device/loss', 'device@loss');
    Route::get('/device/all', 'device@showAll');




    Route::post('dc/newDC', 'dc@newDC');
    Route::post('dc/getDCNumber', 'dc@generateDCNumber');
    Route::get('dc/showAll', 'dc@showAll');
    Route::get('dc/currentAssignments', 'dc@currentAssignments');
    Route::post('dc/create', 'dc@create');
    Route::get('dc/uploadDocuments', 'dc@uploadDocumentsSelectDC');
    Route::get('dc/documentsForDC', 'dc@documentsForDC');
    Route::post('dc/documentUpload', 'dc@documentUpload');
    Route::get('dc/manageDC', 'dc@manageDC');
    Route::get('dc/updateForm', 'dc@updateForm');
    Route::get('dc/updateDCSelection', 'dc@updateDCSelection');
    Route::post('dc/update', 'dc@update');
    Route::get('dc/getDownload', 'dc@getDownload');
    Route::get('/dc/markDeliveredSelection', 'dc@markDeliveredSelection');

    Route::get('/dc/markDeliveredForm', 'dc@markDeliveredForm');
    Route::post('/dc/markDelivered', 'dc@markDelivered');


    Route::post('/dc/validateDCNumber/{dc_number}', 'dc@validateDCNumber');


    Route::get('home', 'panel@home');

    Route::get($base_url . '/', 'panel@index');


    Route::get($base_url . '/test', 'panel@test');
    Route::get($base_url . '/test2', 'panel@test2');


    Route::get($base_url . '/auth/logout', 'Auth\AuthController@logout');


});

