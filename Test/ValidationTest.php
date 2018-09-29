<?php declare(strict_types=1);

use Sepia\Uploader\Exception\ValidationException;

class ValidationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @dataProvider coreErrors
     */
    public function detectCoreError($error)
    {
        $_FILES['key'] = [
            'name' => 'filename.jpg',
            'type' => 'jpeg',
            'tmp_name' => 'jejejeeje.jpg',
            'size' => 0,
            'error' => $error
        ];

        $fileInfo = \Sepia\Uploader\PostFile::createFromRequest('key');
        $this->expectException(ValidationException::class);
        $this->upload($fileInfo);
    }

    public function coreErrors()
    {
        return [
            [UPLOAD_ERR_INI_SIZE],
            [UPLOAD_ERR_FORM_SIZE],
            [UPLOAD_ERR_PARTIAL],
            [UPLOAD_ERR_NO_FILE],
            [UPLOAD_ERR_NO_TMP_DIR],
            [UPLOAD_ERR_CANT_WRITE],
            [UPLOAD_ERR_EXTENSION]
        ];
    }

    /** @test */
    public function detectEmptyUpload()
    {
        $_FILES['key'] = [
            'name' => 'filename.jpg',
            'type' => 'jpeg',
            'tmp_name' => 'jejejeeje.jpg',
            'size' => 0,
            'error' => UPLOAD_ERR_OK
        ];

        $fileInfo = \Sepia\Uploader\PostFile::createFromRequest('key');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('File is empty.');
        $this->upload($fileInfo);
    }

    /** @test */
    public function detectTooBig()
    {
        $_FILES['key'] = [
            'name' => 'filename.jpg',
            'type' => 'jpeg',
            'tmp_name' => 'jejejeeje.jpg',
            'size' => 123456789,
            'error' => UPLOAD_ERR_OK
        ];

        $fileInfo = \Sepia\Uploader\PostFile::createFromRequest('key');
        $this->expectExceptionMessage('File exceeds maximum allowed size.');
        $this->expectException(ValidationException::class);
        $this->upload($fileInfo);
    }


    /** @test */
    public function acceptCorrectSizeFile()
    {
        $_FILES['key'] = [
            'name' => 'filename.jpg',
            'type' => 'jpeg',
            'tmp_name' => 'jejejeeje.jpg',
            'size' => 123,
            'error' => UPLOAD_ERR_OK
        ];

        $fileInfo = \Sepia\Uploader\PostFile::createFromRequest('key');
        $result = $this->upload($fileInfo);

        $this->assertTrue($result);
    }

    protected function upload(\Sepia\Uploader\FileInfo $fileInfo)
    {
        $validators = [
            new \Sepia\Uploader\Validation\CoreValidation(),
            new \Sepia\Uploader\Validation\Size('1000'),
            new \Sepia\Uploader\Validation\AllowedExtensions(['jpg'])
        ];

        $uploader = new Sepia\Uploader\Uploader($validators);

        return $uploader->upload(new \Test\Utils\BlackHoleStorage(), $fileInfo);
    }
}