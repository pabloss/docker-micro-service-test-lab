<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Unpack;

class UnzippedFileParams implements UnzippedFileParamsInterface
{
    const TARGET_DIR_KEY = 'target_dir';
    const TARGET_FILE_KEY = 'target_file';
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
            self::TARGET_DIR_KEY =>  $this->getTargetDir(),
            self::TARGET_FILE_KEY => $this->getTargetFile(),
        ];
    }
}
