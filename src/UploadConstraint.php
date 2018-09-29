<?php declare(strict_types=1);

namespace Sepia\Uploader;

class UploadConstraint
{
    /** @var string[] */
    private $allowedExtensions;

    /** @var string Human readable max file size */
    private $maxFileSize;

    /** @var string[] */
    private $allowedMimeTypes;

    /** @var ?int */
    private $imageMaxWidth;

    /** @var ?int */
    private $imageMaxHeight;

    public function __construct(array $allowedExtensions, string $maxFileSize, array $allowedMimeTypes = [], ?int $imageMaxWidth = null, ?int $imageMaxHeight = null)
    {
        $this->allowedExtensions = $allowedExtensions;
        $this->maxFileSize = $maxFileSize;
        $this->allowedMimeTypes = $allowedMimeTypes;
        $this->imageMaxWidth = $imageMaxWidth;
        $this->imageMaxHeight = $imageMaxHeight;
    }

    /**
     * @return string[]
     */
    public function getAllowedExtensions(): array
    {
        return $this->allowedExtensions;
    }

    /**
     * @return string
     */
    public function getMaxFileSize(): string
    {
        return $this->maxFileSize;
    }

    /**
     * @return string[]
     */
    public function getAllowedMimeTypes(): array
    {
        return $this->allowedMimeTypes;
    }

    public function getImageMaxWidth(): ?int
    {
        return $this->imageMaxWidth;
    }

    public function getImageMaxHeight(): ?int
    {
        return $this->imageMaxHeight;
    }
}