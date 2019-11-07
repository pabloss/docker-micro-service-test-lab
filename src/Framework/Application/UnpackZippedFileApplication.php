<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\File;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Service\Files\Params;
use App\Framework\Service\Files\UploadedFile;

class UnpackZippedFileApplication
{

    const FILES = 'files';
    /**
     * @var Unpack
     */
    private $unpack;

    /**
     * @var File
     */
    private $file;

    /**
     * @var Dir
     */
    private $dir;

    /**
     * @var string
     */
    private $unpacked_directory;

    /**
     * @var string
     */
    private $uploaded_directory;

    /**
     * UnpackZippedFileApplication constructor.
     * @param Unpack $unpack
     * @param File $file
     * @param Dir $dir
     * @param string $unpacked_directory
     * @param string $uploaded_directory
     */
    public function __construct(
        Unpack $unpack,
        File $file,
        Dir $dir,
        string $unpacked_directory,
        string $uploaded_directory
    ) {
        $this->unpack = $unpack;
        $this->file = $file;
        $this->dir = $dir;
        $this->unpacked_directory = $unpacked_directory;
        $this->uploaded_directory = $uploaded_directory;
    }


    public function unzipToTargetDir(array $filesBag)
    {
        if ($this->file->isMimeTypeOf(UploadedFile::ZIP_MIME_TYPE, $this->uploadedFile($filesBag)->getTargetFile())) {
            $this->dir->sureTargetDirExists($this->unpack->getTargetDir($this->unpacked_directory, $this->uploadedFile($filesBag)->getTargetFile()));
            $this->unpack->unzip($this->uploadedFile($filesBag)->getTargetFile(), $this->unpack->getTargetDir($this->unpacked_directory, $this->uploadedFile($filesBag)->getTargetFile()));
        }
    }

    /**
     * @param array $filesBag
     * @return UploadedFile
     */
    protected function uploadedFile(array $filesBag): UploadedFile
    {
        $this->createParams($filesBag);
        return UploadedFile::instance(Params::getInstance());
    }


    /**
     * @param array $filesBag
     */
    protected function createParams(array $filesBag): void
    {
        Params::createInstance($this->uploaded_directory, $filesBag[self::FILES]);
    }
}
