<?php declare(strict_types=1);

namespace Sepia\Uploader\Validation;

use Sepia\Uploader\Exception\ValidationException;
use Sepia\Uploader\FileInfo;

class CoreValidation implements UploadConstraintValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(FileInfo $fileInfo)
    {
        if ($fileInfo->error() != UPLOAD_ERR_OK) {
            throw new ValidationException($this->uploadErrorToString($fileInfo->error()), (int)$fileInfo->error());
        }
    }

    private function uploadErrorToString(string $error)
    {
        switch ($error) {
            case UPLOAD_ERR_OK:
                //Valor: 0; No hay error, fichero subido con éxito.
                $message = 'No error';
                break;

            case UPLOAD_ERR_INI_SIZE:
                //Valor: 1; El fichero subido excede la directiva upload_max_filesize de php.ini.
                $message = 'File exceeds upload_max_filesize directive specified in php.ini';
                break;

            case UPLOAD_ERR_FORM_SIZE:
                //Valor: 2; El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.
                $message = 'File exceeds MAX_FILE_SIZE directive specified in HTML form.';
                break;

            case UPLOAD_ERR_PARTIAL:
                //Valor: 3; El fichero fue sólo parcialmente subido.
                $message = 'File was partially uploaded.';
                break;

            case UPLOAD_ERR_NO_FILE:
                //Valor: 4; No se subió ningún fichero.
                $message = 'No file was uploaded.';
                break;

            case UPLOAD_ERR_NO_TMP_DIR:
                //Valor: 6; Falta la carpeta temporal. Introducido en PHP 5.0.3.
                $message = 'Missing temporal folder.';
                break;

            case UPLOAD_ERR_CANT_WRITE:
                //Valor: 7; No se pudo escribir el fichero en el disco. Introducido en PHP 5.1.0.
                $message = 'Could not write file on disc.';
                break;

            case UPLOAD_ERR_EXTENSION:
                //Valor: 8; Una extensión de PHP detuvo la subida de ficheros. PHP no proporciona una forma de determinar la extensión que causó la parada de la subida de ficheros; el examen de la lista de extensiones cargadas con phpinfo() puede ayudar. Introducido en PHP 5.2.0.
                $message = 'An extension stopped file upload.';
                break;

            default:
                $message = 'Unknown upload error.';
                break;
        }

        return $message;
    }
}