<?php

use Illuminate\Support\Facades\Route;

// BE
$routeGroup = [
    'as'         => 'books.',
    'prefix'     => 'api/v1/books',
    'middleware' => [
        'api',
    ],
    'namespace'  => 'Modules\ElasticSearch\Http\Controllers',
];

Route::group($routeGroup, function () {
    Route::post('/search', 'BookController@search')->name('search');
});

// FE
$routeGroup = [
    'as'         => 'books.',
    'namespace'  => 'Modules\ElasticSearch\Http\Controllers',
];

Route::group($routeGroup, function () {
    Route::get('/search', 'BookController@searchView')->name('search-view');
});
