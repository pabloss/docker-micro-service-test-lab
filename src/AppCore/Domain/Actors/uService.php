<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

class uService
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $file;
    /**
     * @var string
     */
    private $movedToDir;

    /**
     * uService constructor.
     *
     * @param string $file
     * @param string $movedToDir
     */
    public function __construct(string $file, string $movedToDir)
    {

        $this->file = $file;
        $this->movedToDir = $movedToDir;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

    public function fileName()
    {
        return $this->file;
    }

    public function movedToDir()
    {
        return $this->movedToDir;
    }
}
