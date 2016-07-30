<?php

namespace Yarsky\Shopify\Providers;
use Illuminate\Support\ServiceProvider;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/shopify.php';
        $this->publishes([$configPath => config_path('shopify.php')], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Shopify', function ($app) {
            $setup = [
                'API_KEY' => config('shopify.key'),
                'API_SECRET' => config('shopify.secret')
            ];
            $sh = $app->make('ShopifyAPI', $setup);

            return $sh;
        });
    }

    public function provides()
    {
        return ['Shopify'];
    }
}
