<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uServiceInterface;

/**
 * 1. SRP - OK
 * 2. OCP - OK
 * 3. LSP - don't know
 * 4. ISP - OK
 * 5. DIP - OK
 * Class uServiceEntity
 *
 * @package App\AppCore\Domain\Repository
 */
class uServiceEntity implements uServiceEntityInterface
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

    /**
     * @param string $movedToDir
     */
    public function setMovedToDir(string $movedToDir): void
    {
        $this->movedToDir = $movedToDir;
    }
}
