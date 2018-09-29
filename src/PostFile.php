<?php declare(strict_types=1);

namespace Sepia\Uploader;

class PostFile implements FileInfo
{
    /** @var string */
    private $name;

    /** @var string mime type of the file */
    private $type;

    /** @var int Size in bytes */
    private $size;

    /** @var string */
    private $tmpName;

    /** @var int */
    private $error;

    public function __construct(string $name, string $type, int $size, string $tmpName, int $error)
    {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->tmpName = $tmpName;
        $this->error = $error;
    }

    public static function createFromRequest(string $key): self
    {
        if (\count($_FILES) === 0) {
            throw new \RuntimeException('No uploaded file found.');
        }

        if (!isset($_FILES[$key])) {
            throw new \RuntimeException('No uploaded file found.');
        }
        $file = $_FILES[$key];

        return new PostFile($file['name'], $file['type'], $file['size'] ?? 0, $file['tmp_name'], $file['error'] ?? UPLOAD_ERR_OK);
    }

    public function nameWithExtension(): string
    {
        return $this->name;
    }

    public function extension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function pathName(): string
    {
        return $this->tmpName;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function error(): string
    {
        return (string)$this->error;
    }
}