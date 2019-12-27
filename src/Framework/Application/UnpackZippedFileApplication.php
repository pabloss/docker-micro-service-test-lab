<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Application\Stages\Unpack\UnzippedFileParams;
use App\AppCore\Domain\Application\Stages\Unpack\UnzippedFileParamsInterface;
use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\DirInterface;
use App\AppCore\Domain\Service\Files\File;
use App\AppCore\Domain\Service\Files\FileInterface;
use App\AppCore\Domain\Service\Files\Unpack;
use App\AppCore\Domain\Service\Files\UnpackInterface;
use App\Framework\Service\Files\UploadedFile;

class UnpackZippedFileApplication implements UnpackZippedFileApplicationInterface
{
    /**
     * @var UnpackInterface
     */
    private $unpack;

    /**
     * @var FileInterface
     */
    private $file;

    /**
     * @var DirInterface
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
     * @param UnpackInterface $unpack
     * @param FileInterface $file
     * @param DirInterface $dir
     * @param string $unpacked_directory
     * @param string $uploaded_directory
     */
    public function __construct(
        UnpackInterface $unpack,
        FileInterface $file,
        DirInterface $dir,
        string $unpacked_directory,
        string $uploaded_directory
    ) {
        $this->unpack = $unpack;
        $this->file = $file;
        $this->dir = $dir;
        $this->unpacked_directory = $unpacked_directory;
        $this->uploaded_directory = $uploaded_directory;
    }


    public function unzipToTargetDir(array $filesBag): UnzippedFileParamsInterface
    {
        \var_dump($this->file->isMimeTypeOf(
            UploadedFile::ZIP_MIME_TYPE,
            $this->getUploadedFile($filesBag)->getTargetFile()
        ));
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
