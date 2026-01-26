<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('bale-disnaker::index');
    })->name('index');

    Route::name('bale.')->group(function () {
        // Routes untuk landing page disnaker
        // TODO: Implementasi routes sesuai kebutuhan
        // Route::get('page/{page}', PageIndex::class)->name('view-page');
        // Route::get('posts', PostList::class)->name('post-list');
        // Route::get('post/{post}', PostShow::class)->name('view-post');
        // Route::get('event-lists', EventList::class)->name('event-list');
    });
});
