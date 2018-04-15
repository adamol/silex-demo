<?php

namespace Books;

class ImageResizer
{
    private $imageManager;

    private $storage;

    public function __construct(ImageManager $imageManager, \Framework\Storage $storage)
    {
        $this->imageManager = $imageManager;
        $this->storage = $storage;
    }

    public function handle(\Framework\Job $job)
    {
        $imageContents = $this->storage->get($job->getOptions()['image_path']);

        $image = $this->imageManager
            ->make($imageContents)
            ->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->limitColors(255)
            ->encode();

        $this->storage->put($jobOptions['image_path'], (string) $image);
    }
}
