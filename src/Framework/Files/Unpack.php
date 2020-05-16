<?php
declare(strict_types=1);

namespace App\Framework\Files;

class Unpack implements UnpackInterface
{
    private $zipArchive;
    /**
     * @var File
     */
    private $file;

    public function __construct()
    {
        $this->zipArchive = new \ZipArchive();
        $this->file = new File();
    }

    public function unzip(string $zipFilePath, string $dirName)
    {
        // todo: cleanup code repetitions
        if ($this->zipArchive->open($zipFilePath) === true) {
            $extractTo = $this->zipArchive->extractTo($dirName);
            $close = $this->zipArchive->close();
            return $extractTo && $close;
        } else {
            return false;
        }
    }

    /**
     * @param string $parentDir
     * @param string $filePath
     * @return \ZipArchive
     */
    public function getTargetDir(string $parentDir, string $filePath): string
    {
        return  $parentDir . '/' . $this->file->getBasenameWithoutExtension($filePath);
    }
}
