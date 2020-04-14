<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Actors\FileInterface;

class File implements FileInterface
{
    /** @var string */
    private $path;

    /**
     * File constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }


    public function getBasename(): string
    {
        return \basename($this->path);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function move(string $dir): FileInterface
    {
        return $this;
    }

}
