<?php declare(strict_types=1);

namespace Sepia\Uploader\Storage;

use Sepia\Uploader\Exception\UploadException;
use Sepia\Uploader\FileInfo;

interface Storage
{
    /**
     */
    public function upload(FileInfo $fileInfo, ?string $path = null, ?string $newFilename = null): string;

    public function exists(string $pathFilename): bool;
}