<?php declare(strict_types=1);

namespace Sepia\Uploader;

class UploadedFileInfo
{
    /** @var string */
    private $originalFilename;

    /** @var string */
    private $pathFilename;

    public function __construct(string $originalFilename, string $pathFilename)
    {
        $this->originalFilename = $originalFilename;
        $this->pathFilename = $pathFilename;
    }

    public function pathFilename(): string
    {
        return $this->pathFilename;
    }

    public function originalFilename(): string
    {
        return $this->originalFilename;
    }
}