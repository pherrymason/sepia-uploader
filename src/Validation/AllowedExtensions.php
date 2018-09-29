<?php declare(strict_types=1);

namespace Sepia\Uploader\Validation;

use Sepia\Uploader\Exception\ValidationException;
use Sepia\Uploader\FileInfo;

class AllowedExtensions implements UploadConstraintValidator
{
    /** @var string[] */
    protected $allowedExtensions = [];

    public function __construct(array $allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    public function validate(FileInfo $fileInfo)
    {
        if (!\in_array($fileInfo->extension(), $this->allowedExtensions)) {
            throw new ValidationException(
                sprintf('File has an invalid extension, it should be one of %s', implode(', ', $this->allowedExtensions))
            );
        }
    }
}