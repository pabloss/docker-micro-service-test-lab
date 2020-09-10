<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

/**
 *
 * 1. SRP - OK
 * 2. OCP - OK
 * 3. LSP - OK
 * 4. SIP - OK
 * 5. DIP - OK
 * Class uService
 *
 * @package App\AppCore\Domain\Actors
 */
class uService implements uServiceInterface
{
    /**
     * @var string
     */
    private $file;
    /**
     * @var string
     */
    private $movedToDir;
    private $unpackedLocation;

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

    public function getFile()
    {
        return $this->file;
    }

    public function movedToDir()
    {
        return $this->movedToDir;
    }

    public function setMovedToDir(string $movedToDir)
    {
        $this->movedToDir = $movedToDir;
    }

    public function unpacked()
    {
        return $this->unpackedLocation;
    }

    public function setUnpacked(string $unpackedLocation)
    {
        $this->unpackedLocation = $unpackedLocation;
    }

}
