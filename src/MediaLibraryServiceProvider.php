<?php

namespace Nicklasos\LaravelAdmin\MediaLibrary;

use Illuminate\Support\ServiceProvider;
use Encore\Admin\Admin;
use Encore\Admin\Form;

class MediaLibraryServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(MediaLibrary $extension)
    {
        Admin::booting(function(){
            Form::extend('mediaLibrary', MediaLibraryFile::class);
            Form::extend('multipleMediaLibrary', MediaLibraryMultipleFile::class);
        });

        $this->app->booted(function () {
            if ($this->app->routesAreCached()) {
                return;
            }

            MediaLibrary::routes(__DIR__.'/../routes/web.php');
        });
    }
}
