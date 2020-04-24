<?php
declare(strict_types=1);

namespace App\Framework\Service\Command;

use App\AppCore\Domain\Service\CommandInterface;

class RunCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $containerName;
    /**
     * @var string
     */
    private $imageName;

    public function __construct(string $containerName, string $imageName)
    {
        $this->containerName = $containerName;
        $this->imageName = $imageName;
    }

    public function command(): string
    {
        return "docker run --name {$this->containerName} --rm -it -d {$this->imageName}:latest";
    }

}
