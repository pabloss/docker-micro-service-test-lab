<?php
declare(strict_types=1);

namespace App\Framework\Application;

class UnzippedFileParams
{
    /**
     * @var string
     */
    private $targetDir;
    /**
     * @var string
     */
    private $targetFile;

    /**
     * UnzippedFileParams constructor.
     * @param string $targetDir
     * @param string $targetFile
     */
    public function __construct(string $targetDir, string $targetFile)
    {
        $this->targetDir = $targetDir;
        $this->targetFile = $targetFile;
    }

    /**
     * @return string
     */
    public function getTargetDir(): string
    {
        return \basename($this->targetDir);
    }

    /**
     * @return string
     */
    public function getTargetFile(): string
    {
        return \basename($this->targetFile);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'target_dir' => $this->getTargetDir(),
            'target_file' => $this->getTargetFile(),
        ];
    }
}
