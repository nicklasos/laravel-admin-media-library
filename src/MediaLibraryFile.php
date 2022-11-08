<?php

namespace Nicklasos\LaravelAdmin\MediaLibrary;

use Encore\Admin\Form\Field\File;
#use Spatie\MediaLibrary\Models;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaLibraryFile extends File
{
    use MediaLibraryBase;

    protected $view = 'admin::form.file';

    public function fill($data)
    {
        parent::fill($data);

        $value = $this->form->model()->getMedia($this->column());

        if ($value->count()) {
            $this->value = $value->first()->id;
        } else {
            $this->value = [];
        }
    }

    public function prepare($file)
    {
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }

        $this->prepareMedia($file);
    }

    protected function prepareMedia(UploadedFile $file = null)
    {
        $this->name = $this->getStoreName($file);

        $this->form->model()->clearMediaCollection($this->column());

        return $this->form->saved(function($form)use($file){return $this->uploadMedia($file);});
    }

    protected function initialPreviewConfig()
    {
        $media = $this->form->model()->getMedia($this->column);

        return [$this->getPreviewEntry($media)];
    }

    public function setOriginal($data)
    {
        $value = $this->form->model()->getMedia($this->column);
        if ($value->count()) {
            $this->original = $value[0]->id;
        }
    }

    public function destroy()
    {
        $id = $this->original;

        if ($id) {
            $this->form->model()->clearMediaCollection($this->column());
        }
    }
}
