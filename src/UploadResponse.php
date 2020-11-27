<?php declare(strict_types=1);

namespace Sepia\Uploader;

use Sepia\Http\JsonResponse;

class UploadResponse extends JsonResponse
{
    /** @var \Model_Media */
    private $media;

    /**
     * UploadResponse constructor.
     * @param \Model_Media $media
     */
    public function __construct(\Model_Media $media)
    {
        $this->media = $media;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function sendContent()
    {
        echo \Json::encode([
            'success' => true,
            'media' => [
                'id' => $this->media->getId(),
                'filename' => $this->media->getPath(),
                'url' => $this->media->url()
            ]
        ], JSON_NUMERIC_CHECK);

        return $this;
    }
}