<?php
declare(strict_types=1);

namespace App\Framework\Service;

use App\AppCore\Domain\Service\UnpackInterface;
use App\MixedContext\Domain\Service\Files\File;

class UnpackAdapter implements UnpackInterface
{

    private $zipArchive;


    /**
     * UnpackAdapter constructor.
     *
     * @param \ZipArchive $zipArchive
     */
    public function __construct(\ZipArchive $zipArchive)
    {
        $this->zipArchive = $zipArchive;
    }

    public function unpack(string $zipFilePath, string $dirName)
    {
        if ($this->zipArchive->open($zipFilePath) === true) {
            $extractTo = $this->zipArchive->extractTo($dirName);
            $close = $this->zipArchive->close();
            return $extractTo && $close;
        } else {
            return false;
        }
    }

}
