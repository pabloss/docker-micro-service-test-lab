<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

class uServiceEntity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $movedToDir;

    /**
     * @var string
     */
    private $file;

    /**
     * uServiceEntity constructor.
     *
     * @param string $id
     * @param string $movedToDir
     * @param string $file
     */
    public function __construct(string $id, string $movedToDir, string $file)
    {
        $this->id = $id;
        $this->movedToDir = $movedToDir;
        $this->file = $file;
    }

    public function id()
    {
        return $this->id;
    }

    public function file()
    {
        return $this->file;
    }

    public function movedToDir()
    {
        return $this->movedToDir;
    }
}
