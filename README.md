Spatie Media-Library extension for Laravel-Admin
======

### Install

```
composer require nicklasos/laravel-admin-media-library
```

### Usage
```php
protected function form()
{
    $form = new Form(new MyModel);

    // Single media
    $form->mediaLibrary('image', 'Image')
        ->responsive()
        ->removable();

    // Multiple media field
    $form->multipleMediaLibrary('photos', 'Photos')
        ->responsive()
        ->removable();

    return $form;
}
```

Note: you have to add setPhotosAttribute and setImageAttribute methods to your model:
```php
class MyModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function setPhotosAttribute()
    {
        // you can leave it empty
    }

    public function setImageAttribute()
    {

    }
}
```

Thanks to [luischavez/laravel-admin-media-library](https://github.com/luischavez/laravel-admin-media-library) for code samples.
