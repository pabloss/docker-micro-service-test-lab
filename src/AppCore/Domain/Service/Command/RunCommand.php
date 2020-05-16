<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

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
