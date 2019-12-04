<?php
declare(strict_types=1);

namespace App\Framework\Service\Files;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile as BaseUploadedFile;

class UploadedFile implements UploadedFileInterface
{
    const ZIP_MIME_TYPE = 'application/zip';
    const FILES = 'files';

    /** @var BaseUploadedFile */
    private $baseUploadedFile;

    /** @var string */
    private $uuid;

    /**
     * @var string
     */
    private $targetDir;

    /**
     * @var self
     */
    private static $instance;

    /**
     * UploadedFile constructor.
     * @param string $targetDir
     * @param BaseUploadedFile $baseUploadedFile
     */
    private function __construct(string $targetDir, BaseUploadedFile $baseUploadedFile)
    {
        $this->baseUploadedFile = $baseUploadedFile;
        $this->targetDir = $targetDir;
        $this->uuid = uniqid();
    }

    /**
     * @param Params $params
     * @return UploadedFile
     */
    public static function instance(Params $params ): self
    {
        if(null === self::$instance){
            self::$instance = new self($params->getTargetDir(), $params->getUploadedFile());
        }
        return self::$instance;
    }

    /**
     * @param string $targetDir
     * @param BaseUploadedFile $uploadedFile
     * @return UploadedFile
     */
    public static function fromTargetDirAndBaseUploadedFile(string $targetDir, BaseUploadedFile $uploadedFile): self
    {
        if(null === self::$instance){
            self::$instance = new self($targetDir, $uploadedFile);
        }
        return self::$instance;
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

    /**
     * @return string
     */
    public function getTargetFile(): string
    {
        return $this->targetDir . '/' . $this->getUniqueFileName();
    }
}
