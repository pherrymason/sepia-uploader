<?php declare(strict_types=1);

namespace Test\Utils;

use Sepia\Uploader\Exception\UploadException;
use Sepia\Uploader\FileInfo;
use Sepia\Uploader\Storage\Storage;

class BlackHoleStorage implements Storage
{
    /**
     * @throws UploadException
     */
    public function upload(FileInfo $fileInfo)
    {
        // TODO: Implement upload() method.
    }
}