<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Application\Stages\Unpack\UnzippedFileParams;
use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\File;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Service\Files\UploadedFile;

class UnpackZippedFileApplication
{
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


    public function unzipToTargetDir(array $filesBag): UnzippedFileParams
    {
        if (
            $this->file->isMimeTypeOf(
                UploadedFile::ZIP_MIME_TYPE,
                $this->getUploadedFile($filesBag)->getTargetFile()
            )
        ) {
            $this->dir->sureTargetDirExists(
                $this->getTargetDir($filesBag)
            );
            $this->unpack->unzip(
                $this->getUploadedFile($filesBag)->getTargetFile(),
                $this->getTargetDir($filesBag)
            );
        }

        return new UnzippedFileParams(
            $this->getTargetDir($filesBag),
            $this->getUploadedFile($filesBag)->getTargetFile(),
        );
    }

    /**
     * @param array $filesBag
     * @return UploadedFile
     */
    private function getUploadedFile(array $filesBag): UploadedFile
    {
        return UploadedFile::fromTargetDirAndBaseUploadedFile(
            $this->uploaded_directory,
            $filesBag[UploadedFile::FILES]
        );
    }

    /**
     * @param array $filesBag
     * @return string|\ZipArchive
     */
    private function getTargetDir(array $filesBag)
    {
        return $this->unpack->getTargetDir(
            $this->unpacked_directory,
            $this->getUploadedFile($filesBag)->getTargetFile()
        );
    }
}
