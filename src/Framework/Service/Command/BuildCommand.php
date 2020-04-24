<?php
declare(strict_types=1);

namespace App\Framework\Service\Command;

use App\AppCore\Domain\Service\CommandInterface;

class BuildCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $dockerFilePath;
    /**
     * @var string
     */
    private $imageName;

    public function __construct(string $dockerFilePath, string $imageName)
    {
        $this->dockerFilePath = $dockerFilePath;
        $this->imageName = $imageName;
    }

    public function command(): string
    {
        $dir = \dirname($this->dockerFilePath);
        return "docker build -f {$this->dockerFilePath} -t {$this->imageName} {$dir}";
    }

}
