<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

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
     * @var string
     */
    private $unpackedLocation;
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var TestEntity
     */
    private $test;

    /**
     * uServiceEntity constructor.
     *
     * @param string      $movedToDir
     * @param string      $file
     * @param string      $uuid
     * @param string|null $id
     */
    public function __construct(string $movedToDir, string $file, string $uuid, ?string $id = null)
    {
        $this->id = $id;
        $this->movedToDir = $movedToDir;
        $this->file = $file;
        $this->uuid = $uuid;
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

    public function unpacked()
    {
        return $this->unpackedLocation;
    }

    public function setUnpacked(string $unpackedLocation)
    {
        $this->unpackedLocation = $unpackedLocation;
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->uuid;
    }

    public function getTest(): ?TestEntity
    {
        return $this->test;
    }

    /**
     * @param TestEntity|null $test
     *
     * @return uServiceEntity
     */
    public function setTest(?TestEntity $test): self
    {
        $this->test = $test;
        return $this;
    }
}
