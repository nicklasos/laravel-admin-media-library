<?php

namespace Nicklasos\LaravelAdmin\MediaLibrary;

use Encore\Admin\Form\NestedForm;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use URL;

trait MediaLibraryBase
{
    private $responsive = false;

    public function responsive()
    {
        $this->responsive = true;

        return $this;
    }

    public function uploadMedia(UploadedFile $file = null)
    {
        $media = $this->form
            ->model()
            ->addMedia($file)
            ->preservingOriginal();

        if ($this->responsive) {
            $media->withResponsiveImages();
        }

        $media = $media
            ->toMediaCollection($this->column())
            ->toArray();

        $media[NestedForm::REMOVE_FLAG_NAME] = 0;

        return tap($media, function () {
            $this->name = null;
        });
    }

    public function objectUrl($mediaId)
    {
        $media = $this->form
            ->model()->getMedia($this->column)->first();
        return $media->getUrl();
    }

    private function getPreviewEntry(MediaCollection $media)
    {
        $media = $media->first();
        $type = $this->getMimeType($media->mime_type);

        $entry = [
            'caption' => $media->file_name,
            'key' => $media->id,
            'size' => $media->size,
        ];

        if (!empty($type)) {
            $entry['type'] = $type;
        }

        return $entry;
    }

    private function getMimeType(string $mime): string
    {
        switch ($mime) {
            case 'image/jpeg':
            case 'image/png':
                $type = 'image';
                break;
            case 'application/pdf':
                $type = 'pdf';
                break;
            case 'text/plain':
                $type = 'text';
                break;
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $type = 'office';
                break;
            case 'image/tiff':
                $type = 'gdocs';
                break;
            case 'text/html':
                $type = 'html';
                break;
            case 'video/mp4':
            case 'application/mp4':
            case 'video/x-sgi-movie':
                $type = 'video';
                break;
            case 'audio/mpeg':
            case 'audio/mp3':
                $type = 'audio';
                break;

            default:
                $type = 'image';
        }

        return $type;
    }
}
