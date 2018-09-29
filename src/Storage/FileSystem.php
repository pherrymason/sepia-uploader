<?php declare(strict_types=1);

namespace Sepia\Uploader\Storage;

use Sepia\Uploader\Exception\UploadException;
use Sepia\Uploader\FileInfo;

class FileSystem implements Storage
{
    /** @var bool */
    protected $overwrite;

    /** @var string */
    protected $directory;

    public function __construct(bool $overwrite, string $directory)
    {
        $this->overwrite = $overwrite;
        $this->directory = $directory;
    }

    /**
     * @param FileInfo $fileInfo
     * @param null|string $path
     * @param null|string $newFilename
     * @throws UploadException
     */
    public function upload(FileInfo $fileInfo, ?string $path = null, ?string $newFilename = null): string
    {
        if ($path === null) {
            $path = $this->directory;
        }

        if ($newFilename ===  null) {
            $newFilename = $fileInfo->nameWithExtension();
        }

        $destinationFile = rtrim($path , '/') . '/' . $newFilename;

        if ($this->overwrite === false && file_exists($destinationFile)) {
            throw new UploadException('File already exists.');
        }

        $concurrentDirectory = \dirname($destinationFile);
        if (!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        if (!is_writable($concurrentDirectory)) {
            throw new UploadException('Destination path is not writable.');
        }

        if ($this->moveUploadedFile($fileInfo->pathName(), $destinationFile) === false) {
            throw new UploadException('File could not be moved to final destination.');
        }

        return $destinationFile;
    }

    public function exists(string $pathFilename): bool
    {
        return file_exists($pathFilename);
    }

    private function moveUploadedFile(string $source, string $destination)
    {
        return move_uploaded_file($source, $destination);
    }
}