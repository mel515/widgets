<?php

Route::group([
    'namespace' => 'InetStudio\Widgets\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::resource('widgets', 'WidgetsControllerContract', ['only' => [
        'show', 'store', 'update',
    ], 'as' => 'back']);

    Route::post('widgets/gallery/save', 'GalleryWidgetsControllerContract@attachImagesToWidget')->name('back.widgets.gallery.save');
    Route::get('widgets/gallery/get', 'GalleryWidgetsControllerContract@getWidgetImages')->name('back.widgets.gallery.get');
});

Route::group([
    'namespace' => 'InetStudio\Widgets\Contracts\Http\Controllers\Front',
    'middleware' => ['web'],
], function () {
    Route::post('widget/{id}', 'WidgetsControllerContract@getWidget')->name('front.widget.get');
});
