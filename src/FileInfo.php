<?php declare(strict_types=1);

namespace Sepia\Uploader;

/**
 * Information about uploaded file before processing and moving it
 * to final location.
 */
interface FileInfo
{
    public function nameWithExtension(): string;

    public function extension(): string;

    public function pathName(): string;

    public function size(): int;

    public function error(): string;
}