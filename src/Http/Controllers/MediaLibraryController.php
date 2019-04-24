<?php

namespace Nicklasos\LaravelAdmin\MediaLibrary\Http\Controllers;

use Illuminate\Routing\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaLibraryController extends Controller
{
    public function download($id)
    {
        $media = Media::findOrFail($id);

        return response()->download(
            $media->getPath(),
            $media->file_name, ['Content-Type' => $media->mime_type],
            'inline'
        );
    }
}
