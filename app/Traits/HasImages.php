<?php

namespace App\Traits;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasImages
{
    public function getImages(): void
    {
        $interfaces = class_implements(get_class($this));
        if (!isset($interfaces[HasMedia::class]))
        {
            return;
        }

        // I've chosen to use images not media in order not to have
        // any conflicts with spatie media library package
        $this->images = collect([]);

        // load images
        Media::query()
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id)
            ->get()
            ->each(function ($media) {
                $this->images->push([
                    'original' => $media->getUrl(),
                    'conversions' => $this->getImageConversions($media),
                ]);
            });

        // Set the default image when no other images are stored in the db
        if ($this->images->count() === 0) {
            $this->images->push([
                'original' => $this->getFirstMediaUrl()
            ]);
        }
    }

    private function getImageConversions(Media $media): array
    {
        $conversions = [];

        foreach ($media->generated_conversions as $conversion => $key) {
            $conversions[] = $media->getUrl($conversion);
        }

        return $conversions;
    }
}