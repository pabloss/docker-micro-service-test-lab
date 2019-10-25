<?php
declare(strict_types=1);

namespace App\Files;

class Unpack
{
    private $zipArchive;

    public function __construct()
    {
        $this->zipArchive = new \ZipArchive();
    }

    public function unzip(string $zipFilePath, string $dirName)
    {
        // todo: cleanup code repetitions
        if ($this->zipArchive->open($zipFilePath) === true) {
            $extractTo = $this->zipArchive->extractTo(
                $this->sureTargetDirExists(
                    $dirName . $this->getBasenameWithoutExtension($zipFilePath)
                )
            );
            $close = $this->zipArchive->close();
            return $extractTo && $close;
        } else {
            return false;
        }
    }

    /**
     * @param string $extractToDir
     * @return string
     */
    private function sureTargetDirExists(string  $extractToDir): string
    {
        if (false === \file_exists($extractToDir)) {
            \mkdir($extractToDir);
        }
        return $extractToDir;
    }

    /**
     * @param string $filePath
     * @return string
     */
    private function getBasenameWithoutExtension(string $filePath): string
    {
        return \basename($filePath, '.' . $this->getExtension($filePath));
    }

    /**
     * @param string $filePath
     * @return mixed
     */
    private function getExtension(string $filePath)
    {
        return \pathinfo($filePath)['extension'];
    }
}
