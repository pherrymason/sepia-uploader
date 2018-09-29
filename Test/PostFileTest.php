<?php

use PHPUnit\Framework\TestCase;

class PostFileTest extends TestCase
{
    /** @test */
    public function createFileInfoFromRequest()
    {
        $_FILES['key'] = [
            'name' => 'filename.jpg',
            'type' => 'jpeg',
            'tmp_name' => 'jejejeeje.jpg',
            'size' => 1234,
            'error' => UPLOAD_ERR_OK
        ];

        $fileInfo = \Sepia\Uploader\PostFile::createFromRequest('key');

        $this->assertInstanceOf(\Sepia\Uploader\PostFile::class, $fileInfo);
    }
}
