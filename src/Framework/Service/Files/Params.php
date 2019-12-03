<?php
declare(strict_types=1);

namespace App\Framework\Service\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Params
{
    /**
     * @var string
     */
    private $targetDir;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    /**
     * @var self
     */
    private static $instance;

    /**
     * Params constructor.
     * @param string $targetDir
     * @param UploadedFile $uploadedFile
     */
    private function __construct(string $targetDir, UploadedFile $uploadedFile)
    {
        $this->targetDir = $targetDir;
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @return Params
     */
    public static function getInstance(string $targetDir, UploadedFile $uploadedFile): self
    {
        if(null === self::$instance){
            self::$instance = new self($targetDir, $uploadedFile);
        }
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
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
