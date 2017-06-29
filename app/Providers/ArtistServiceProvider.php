<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Artist as ArtistModel;
use App\Services\Artist as ArtistService;

/**
 * Using Laravel's ServiceProvider for service App\Services\Artist, to utilize
 * dependency injection and other things
 */
class ArtistServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        return [ArtistModel::class, ArtistService::class];
    }
}
