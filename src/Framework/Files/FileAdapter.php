<?php
declare(strict_types=1);

namespace App\Framework\Files;

use App\AppCore\Application\UploadedFileFactoryInterface;
use App\AppCore\Domain\Actors\UploadedFileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileAdapter implements UploadedFileInterface
{
    /**
     * @var UploadedFile
     */
    private $frameworkUploadedFile;

    /**
     * UploadedFileAdapter constructor.
     *
     * @param UploadedFile $frameworkUploadedFile
     */
    public function __construct(UploadedFile $frameworkUploadedFile)
    {
        $this->frameworkUploadedFile = $frameworkUploadedFile;
    }


    public function getBasename(): string
    {
        return $this->frameworkUploadedFile->getBasename();
    }

    public function getPath(): string
    {
        return $this->frameworkUploadedFile->getPathname();
    }
}
