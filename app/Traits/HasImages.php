<?php

namespace App\Traits;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasImages
{
    public function getMediaUrls(): void
    {
        $interfaces = class_implements(get_class($this));
        if (!isset($interfaces[HasMedia::class]))
        {
            return;
        }

        // initialize the media file
        $this->medias = collect([]);

        $this->media->each(function ($media) {
            $mediaFile = new MediaFile(
                originalImage: $media->getUrl(),
                thumbnails: $media->getGeneratedConversions()->keys()->map(function ($conversion) use ($media) {
                    return $media->getUrl($conversion);
                })->all()
            );

            $this->medias->push($mediaFile);
        });

        // Set a default image when no images are found
        if ($this->medias->isEmpty()) {
            $mediaFile = new MediaFile(
            // it generates a default image implicitly
                originalImage: $this->getFirstMediaUrl(),
            );

            $this->medias->push($mediaFile);
        }
    }
}