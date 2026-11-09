<?php

use Bale\Tala\Http\Middleware\EnsureTalaSession;
use Illuminate\Support\Facades\Route;
use Paparee\BaleDisnaker\Livewire\Index;
use Paparee\BaleDisnaker\Livewire\LandingPage\Job\JobDetail;
use Paparee\BaleDisnaker\Livewire\LandingPage\Job\JobList;
use Paparee\BaleDisnaker\Livewire\LandingPage\Page\Index as PageIndex;
use Paparee\BaleDisnaker\Livewire\LandingPage\Post\PostList;
use Paparee\BaleDisnaker\Livewire\LandingPage\Post\Show as PostShow;
use Paparee\BaleDisnaker\Livewire\Pelatihan\Form as PelatihanForm;
use Paparee\BaleDisnaker\Livewire\Pelatihan\Index as PelatihanIndex;
use Paparee\BaleDisnaker\Livewire\Service\Index as ServiceIndex;

Route::middleware(['web'])->group(function () {
    Route::get('/', Index::class)->name('index');

    Route::name('bale.')->group(function () {
        // Routes untuk landing page disnaker
        Route::get('page/{page}', PageIndex::class)->name('view-page');
        Route::get('posts', PostList::class)->name('post-list');
        Route::get('post/{post}', PostShow::class)->name('view-post');
        Route::get('jobs', JobList::class)->name('jobs');
        Route::get('jobs/{slug}', JobDetail::class)->name('view-job');
        Route::get('services', ServiceIndex::class)->name('services');
    });

    // Portal pelatihan (milik disnaker; tala hanya menyediakan login + panel).
    Route::name('disnaker.pelatihan.')->group(function () {
        Route::get('pelatihan', PelatihanIndex::class)->name('index');

        Route::middleware(['auth:tala', EnsureTalaSession::class])->group(function () {
            Route::get('pelatihan/masyarakat', PelatihanForm::class)
                ->defaults('type', 'masyarakat')
                ->name('masyarakat');

            Route::get('pelatihan/perusahaan', PelatihanForm::class)
                ->defaults('type', 'perusahaan')
                ->name('perusahaan');
        });
    });
});
