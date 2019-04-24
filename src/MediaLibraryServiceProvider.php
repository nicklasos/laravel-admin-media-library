<?php

namespace Nicklasos\LaravelAdmin\MediaLibrary;

use Illuminate\Support\ServiceProvider;

class MediaLibraryServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(MediaLibrary $extension)
    {
        if (! MediaLibrary::boot()) {
            return ;
        }

        $this->app->booted(function () {
            if ($this->app->routesAreCached()) {
                return;
            }

            MediaLibrary::routes(__DIR__.'/../routes/web.php');
        });
    }
}
