<?php

namespace App\Observers;

use Spatie\MediaLibrary\HasMedia;

class MediaObserver
{
    public function deleting($model)
    {
        if ($model instanceof HasMedia) {
            $collections = $model->media->pluck('collection_name')->unique();

            foreach ($collections as $collection) {
                $model->clearMediaCollection($collection);
            }
        }
    }
}
