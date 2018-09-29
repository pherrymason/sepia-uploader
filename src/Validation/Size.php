<?php declare(strict_types=1);

namespace Sepia\Uploader\Validation;

use Sepia\Uploader\Exception\ValidationException;
use Sepia\Uploader\FileInfo;

class Size implements UploadConstraintValidator
{
    /** @var int */
    private $maximumSize;

    public function __construct(string $maximumSize)
    {
        $this->maximumSize = $this->convertToBytes($maximumSize);
    }

    public function validate(FileInfo $fileInfo)
    {
        if ($fileInfo->size() === 0) {
            throw new ValidationException('File is empty.');
        }

        if ($fileInfo->size() > $this->maximumSize) {
            throw new ValidationException('File exceeds maximum allowed size.');
        }
    }

    private function convertToBytes(string $from): ?int {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $number = substr($from, 0, -2);
        $suffix = strtoupper(substr($from,-2));

        //B or no suffix
        if(is_numeric(substr($suffix, 0, 1))) {
            return preg_replace('/[^\d]/', '', $from);
        }

        $exponent = array_flip($units)[$suffix] ?? null;
        if($exponent === null) {
            return null;
        }

        return $number * (1024 ** $exponent);
    }
}