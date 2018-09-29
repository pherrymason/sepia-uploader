<?php declare(strict_types=1);

namespace Sepia\Uploader\Validation;

use Sepia\Uploader\Exception\ValidationException;
use Sepia\Uploader\FileInfo;

interface UploadConstraintValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(FileInfo $fileInfo);
}