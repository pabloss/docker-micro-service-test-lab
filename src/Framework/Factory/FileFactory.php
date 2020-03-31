<?php
declare(strict_types=1);

namespace App\Framework\Factory;

use App\AppCore\Application\UploadedFileFactoryInterface;
use App\AppCore\Domain\Actors\FileInterface;
use App\Framework\Files\FileAdapter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileFactory implements UploadedFileFactoryInterface
{
    public function createUploadedFile(string $file): FileInterface
    {
        return new FileAdapter(new UploadedFile($file, \basename($file)));
    }
}
