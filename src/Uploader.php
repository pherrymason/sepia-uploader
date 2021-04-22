<?php

namespace Sepia\Uploader;

use Sepia\Uploader\Exception\UploadException;
use Sepia\Uploader\Storage\Storage;
use Sepia\Uploader\Validation\UploadConstraintValidator;

class Uploader
{
    /** @var UploadConstraintValidator[] */
    private $constraints;

    public function __construct(array $constraints)
    {
        $this->constraints = $constraints;
    }

    /**
     * @throws UploadException
     * @throws Exception\ValidationException
     */
    public function upload(
        Storage $storageUploader,
        FileInfo $fileInfo,
        ?string $destinyPath,
        ?string $newFilename = null): UploadedFileInfo
    {
        $this->validate($fileInfo);

        $pathFilename = $storageUploader->upload($fileInfo, $destinyPath, $newFilename);

        return new UploadedFileInfo(
            $fileInfo->nameWithExtension(),
            $pathFilename
        );
    }

    /**
     * @throws Exception\ValidationException
     */
    protected function validate(FileInfo $fileInfo)
    {
        foreach ($this->constraints as $constraint) {
            $constraint->validate($fileInfo);
        }
    }
}
