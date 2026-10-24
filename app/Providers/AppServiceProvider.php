<?php
namespace App\Providers;
use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        View::composer('*', function ($view) {
            static $settings = null;
            if ($settings === null) {
                try { $settings = Schema::hasTable('site_settings') ? SiteSetting::all()->pluck('value','key')->all() : []; }
                catch (\Throwable $e) { $settings = []; }
            }
            $view->with('siteConfig', $settings);
        });
    }
}
