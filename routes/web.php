<?php

use Illuminate\Support\Facades\Route;
use Paparee\BaleDisnaker\Livewire\Index;
use Paparee\BaleDisnaker\Livewire\LandingPage\Post\PostList;
use Paparee\BaleDisnaker\Livewire\LandingPage\Post\Show as PostShow;
use Paparee\BaleDisnaker\Livewire\LandingPage\Job\JobList;
use Paparee\BaleDisnaker\Livewire\LandingPage\Job\JobDetail;
use Paparee\BaleDisnaker\Livewire\LandingPage\Page\Index as PageIndex;
use Paparee\BaleDisnaker\Livewire\Service\Index as ServiceIndex;

Route::middleware(['web'])->group(function () {
    Route::get('/', Index::class)->name('index');


    Route::name('bale.')->group(function () {
        // Routes untuk landing page disnaker
        Route::get('page/{page}', PageIndex::class)->name('view-page');
        Route::get('posts', PostList::class)->name('post-list');
        Route::get('post/{post}', PostShow::class)->name('view-post');
        Route::get('jobs', JobList::class)->name('jobs');
        Route::get('jobs/{id}', JobDetail::class)->name('view-job');
        Route::get('services', ServiceIndex::class)->name('services');
    });
});
