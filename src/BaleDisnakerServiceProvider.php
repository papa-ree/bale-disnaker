<?php

namespace Paparee\BaleDisnaker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Component as LivewireComponent;
use Livewire\Livewire;
use Symfony\Component\Finder\Finder;

class BaleDisnakerServiceProvider extends ServiceProvider
{
    /**
     * Method register()
     * 
     * Digunakan untuk mendaftarkan service, binding, atau command
     * ke dalam service container Laravel.
     */
    public function register(): void
    {
        $this->registerCommands();
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
        // Only load routes if this landing page is active
        if ($this->isActiveLandingPage()) {
            $this->app->booted(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });
        }

        $this->offerPublishing();

        $this->registerViews();
        $this->registerLivewireComponents();
    }

    /**
     * Check if this landing page is currently active
     */
    protected function isActiveLandingPage(): bool
    {
        $activePage = config('landing-page.active', 'disnaker');
        return $activePage === 'disnaker';
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
        $namespace = "Paparee\\BaleDisnaker\\Livewire";
        $basePath = __DIR__ . "/Livewire";

        // Jika folder Livewire tidak ada, hentikan proses
        if (!is_dir($basePath)) {
            return;
        }

        $finder = new Finder();
        $finder->files()->in($basePath)->name('*.php');

        foreach ($finder as $file) {
            $relativePathname = $file->getRelativePathname();

            // Normalisasi path (Windows/Linux)
            $nsPath = str_replace(['/', '\\'], '\\', $relativePathname);

            // Konversi ke FQCN (Fully Qualified Class Name)
            $class = $namespace . '\\' . Str::beforeLast($nsPath, '.php');

            // Skip jika class tidak ditemukan
            if (!class_exists($class)) {
                continue;
            }

            // Skip jika bukan turunan Livewire\Component
            if (!is_subclass_of($class, LivewireComponent::class)) {
                continue;
            }

            // Buat alias berdasarkan struktur folder (kebab-case)
            $withoutExt = Str::replaceLast('.php', '', $relativePathname);
            $segments = preg_split('#[\/\\\\]#', $withoutExt);
            $kebab = array_map(fn($s) => Str::kebab($s), $segments);

            $alias = 'bale-disnaker.' . implode('.', $kebab);

            // Registrasi komponen ke Livewire
            Livewire::component($alias, $class);
        }
    }
}
