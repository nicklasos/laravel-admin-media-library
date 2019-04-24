<?php

use Nicklasos\LaravelAdmin\MediaLibrary\Http\Controllers\MediaLibraryController;

Route::get('media/download/{id}', MediaLibraryController::class.'@download')->name('admin.media.download');
