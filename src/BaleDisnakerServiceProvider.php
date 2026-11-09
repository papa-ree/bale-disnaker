<?php

namespace Paparee\BaleDisnaker;

use Bale\Tala\Events\TalaAuthenticated;
use Bale\Tala\Panel;
use Bale\Umpak\Concerns\HasLandingPageGuard;
use Bale\Umpak\Concerns\HasLivewireComponents;
use Bale\Umpak\Umpak;
use Bale\Umpak\UmpakServiceProvider;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Paparee\BaleDisnaker\Listeners\RecordCitizenProfile;
use Paparee\BaleDisnaker\Livewire\Panel\Overview;
use Paparee\BaleDisnaker\Livewire\Panel\ProfilIdentitas;

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
        $this->mergeConfigFrom(__DIR__.'/../config/bale-disnaker.php', 'bale-disnaker');

        $this->registerCommands();

        // Register to Umpak registry using resolving hook
        $this->app->resolving(Umpak::class, function (Umpak $umpak) {
            $umpak->registerLandingPage('disnaker', 'Dinas Tenaga Kerja');
        });

        // Panel warga: hanya saat theme ini aktif.
        if ($this->isActiveLandingPage()) {
            $this->app->resolving(Panel::class, function (Panel $panel) {
                $panel->registerPackage('disnaker', 'Dinas Tenaga Kerja');
                $panel->registerOverview(Overview::class);
                $panel->registerProfileSection(ProfilIdentitas::class);
            });
        }
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
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

                // Daftarkan LandingPageComposer hanya untuk views package ini.
                // Tanpa guard ini, composer akan menjalankan DB query pada semua
                // bale lain yang berjalan di server atau shared Redis yang sama.
                UmpakServiceProvider::registerLandingPageComposer('bale-disnaker::*');
            });

            // Prepend package view directory to prioritize its views (including errors)
            $this->app['view']->prependLocation(__DIR__.'/../resources/views');

            // Guard: Livewire component hanya didaftarkan saat bale ini aktif.
            // Tanpa ini, class reference tersimpan di shared Redis dan crash
            // di project production yang tidak memiliki class tersebut.
            $this->registerLivewireComponents();

            // Profil warga ditulis oleh pemilik tabel pelatihan, bukan tala.
            $this->app['events']->listen(TalaAuthenticated::class, RecordCitizenProfile::class);
        }

        $this->offerPublishing();

        $this->registerViews();
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__.'/../resources/views',
            'bale-disnaker'
        );
    }

    protected function offerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Publish config
        $this->publishes([
            __DIR__.'/../config/bale-disnaker.php' => config_path('bale-disnaker.php'),
        ], 'disnaker:config');

        // Publish error views
        $this->publishes([
            __DIR__.'/../resources/views/errors' => resource_path('views/errors'),
        ], 'disnaker:errors');
    }

    protected function registerLivewireComponents(): void
    {
        $this->discoverLivewireComponents(
            __DIR__.'/Livewire',
            'Paparee\BaleDisnaker\\Livewire',
            'bale-disnaker'
        );
    }
}
