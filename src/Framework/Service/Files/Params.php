<?php
declare(strict_types=1);

namespace App\Framework\Service\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFileAlias;

class Params
{
    /**
     * @var string
     */
    private $targetDir;

    /**
     * @var UploadedFileAlias
     */
    private $uploadedFile;

    /**
     * @var self
     */
    private static $instance;

    /**
     * Params constructor.
     * @param string $targetDir
     * @param UploadedFileAlias $uploadedFile
     */
    private function __construct(string $targetDir, UploadedFileAlias $uploadedFile)
    {
        $this->targetDir = $targetDir;
        $this->uploadedFile = $uploadedFile;
    }

    public static function createInstance(string $targetDir, UploadedFileAlias $uploadedFile): void
    {
        if(null === self::$instance){
            self::$instance = new self($targetDir, $uploadedFile);
        }
    }

    /**
     * @return Params
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getTargetDir(): string
    {
        return $this->targetDir;
    }

    /**
     * @return UploadedFileAlias
     */
    public function getUploadedFile(): UploadedFileAlias
    {
        return $this->uploadedFile;
    }
}
