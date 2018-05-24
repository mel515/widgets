<?php

Route::group([
    'namespace' => 'InetStudio\Widgets\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::resource('widgets', 'WidgetsControllerContract', ['only' => [
        'show', 'store', 'update',
    ], 'as' => 'back']);
});

Route::group([
    'namespace' => 'InetStudio\Widgets\Contracts\Http\Controllers\Front',
    'middleware' => ['web'],
], function () {
    Route::post('widgets', 'WidgetsControllerContract@getWidget')->name('front.widgets.get');
});
