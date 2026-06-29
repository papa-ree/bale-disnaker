<?php

namespace Paparee\BaleDisnaker;

use Bale\Umpak\Concerns\HasLivewireComponents;
use Bale\Umpak\Concerns\HasLandingPageGuard;
use Bale\Umpak\Umpak;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Component as LivewireComponent;
use Livewire\Livewire;
use Symfony\Component\Finder\Finder;

class BaleDisnakerServiceProvider extends ServiceProvider
{
    use HasLandingPageGuard, HasLivewireComponents;

    /**
     * Method register()
     * 
     * Digunakan untuk mendaftarkan service, binding, atau command
     * ke dalam service container Laravel.
     */
    public function register(): void
    {
        $this->registerCommands();

        // Register to Umpak registry using resolving hook
        $this->app->resolving(Umpak::class, function (Umpak $umpak) {
            $umpak->registerLandingPage('disnaker', 'Dinas Tenaga Kerja');
        });
    }

    /**
     * Slug landing page ini
     */
    protected function landingPageSlug(): string
    {
        return 'disnaker';
    }

    protected function registerCommands(): void
    {
        $commands = [
        ];

        foreach ($commands as $key => $class) {
            $this->app->bind($key, $class);
        }

        $this->commands(array_keys($commands));
    }

    /**
     * Method boot()
     * 
     * Dipanggil setelah semua service diregistrasi.
     * Digunakan untuk load resource seperti:
     * - view
     * - migration
     * - konfigurasi
     * - Livewire component
     */
    public function boot(): void
    {
        // Only load resources if this landing page is active
        if ($this->isActiveLandingPage()) {
            $this->app->booted(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

            // Prepend package view directory to prioritize its views (including errors)
            $this->app['view']->prependLocation(__DIR__ . '/../resources/views');
        }

        $this->offerPublishing();

        $this->registerViews();
        $this->registerLivewireComponents();
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'bale-disnaker'
        );
    }

    protected function offerPublishing(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        // Publish config
        $this->publishes([
            __DIR__ . '/../config/bale-disnaker.php' => config_path('bale-disnaker.php'),
        ], 'disnaker:config');

        // Publish error views
        $this->publishes([
            __DIR__ . '/../resources/views/errors' => resource_path('views/errors'),
        ], 'disnaker:errors');
    }

    protected function registerLivewireComponents(): void
    {
        $this->discoverLivewireComponents(
            __DIR__.'/Livewire',
            'Paparee\\BaleDisnaker\\Livewire',
            'bale-disnaker'
        );
    }
}
