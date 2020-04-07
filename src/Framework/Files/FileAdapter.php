<?php
declare(strict_types=1);

namespace App\Framework\Files;

use App\AppCore\Domain\Actors\FileInterface;
use Symfony\Component\HttpFoundation\File\File;

class FileAdapter implements FileInterface
{
    /**
     * @var File
     */
    private $file;

    /**
     * UploadedFileAdapter constructor.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getBasename(): string
    {
        return $this->file->getBasename();
    }

    public function getPath(): string
    {
        return $this->file->getPath();
    }

    public function move(string $dir): FileInterface
    {
        return  $this;
    }
}
