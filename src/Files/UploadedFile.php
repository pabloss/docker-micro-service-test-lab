<?php
declare(strict_types=1);

namespace App\Files;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile as BaseUploadedFile;

class UploadedFile
{
    /** @var BaseUploadedFile */
    private $baseUploadedFile;

    /** @var string */
    private $uuid;

    /**
     * UploadedFile constructor.
     * @param BaseUploadedFile $baseUploadedFile
     */
    public function __construct(BaseUploadedFile $baseUploadedFile)
    {
        $this->baseUploadedFile = $baseUploadedFile;
        $this->uuid = uniqid();
    }

    /**
     * @return string
     */
    public function getUniqueFileName(): string
    {
        return $this->createSafeFileName() . '-' . $this->uuid . '.' . $this->guessExtension();
    }

    /**
     * @param $directory
     * @param null $name
     * @return File
     */
    public function move($directory, $name = null): File
    {
        return $this->baseUploadedFile->move($directory, $name);
    }

    /**
     * @return false|string
     */
    private function createSafeFileName()
    {
        // this is needed to safely include the file name as part of the URL
        return transliterator_transliterate(
            'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
            pathinfo($this->baseUploadedFile->getClientOriginalName(), PATHINFO_FILENAME)
        );
    }

    /**
     * @return string|null
     */
    private function guessExtension(): ?string
    {
        if(empty($this->baseUploadedFile->getExtension())){
            $parts = explode(".", $this->baseUploadedFile->getClientOriginalName());
            return \end($parts);
        }
        return $this->baseUploadedFile->getExtension();
    }
}
