<?php

namespace App\Traits;

class MediaFile
{
    /**
     * @param string $originalImage
     * @param string[] $thumbnails
     */
    public function __construct(
        public readonly string $originalImage = '',
        public readonly array $thumbnails = [],
    ) {
    }

    public function with(...$parameters): static
    {
        $parameters = $parameters + (array)$this;
        return new static(...$parameters);
    }
}