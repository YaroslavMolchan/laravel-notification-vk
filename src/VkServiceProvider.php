<?php

namespace NotificationChannels\Vk;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class VkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(VkChannel::class)
            ->needs(Vk::class)
            ->give(function () {
                return new Vk(
                    config('services.vk-api.token'),
                    new HttpClient()
                );
            });
    }
}
