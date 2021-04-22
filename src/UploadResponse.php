<?php declare(strict_types=1);

namespace Sepia\Uploader;

use Sepia\Framework\Psr7\JsonResponse;

class UploadResponse extends JsonResponse
{
    public function __construct(\Model_Media $media)
    {
        parent::__construct([
            'success' => true,
            'media' => [
                'id' => $media->getId(),
                'filename' => $media->getPath(),
                'url' => '/' . ltrim($media->getPath(), '/') .'/'.$media->fileName()
            ]
        ]);
    }
}
