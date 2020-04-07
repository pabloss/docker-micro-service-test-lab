<?php
declare(strict_types=1);

namespace App\Framework\Files;

use App\AppCore\Domain\Actors\FileInterface;
use Integration\Stubs\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileAdapter implements FileInterface
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * UploadedFileAdapter constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }


    public function getBasename(): string
    {
        return $this->file->getBasename();
    }

    public function getPath(): string
    {
        return $this->file->getPathname();
    }

    public function move(string $dir): FileInterface
    {
        return new FileWrapper($this->file->move($dir, $this->file->getClientOriginalName()));
    }


}
