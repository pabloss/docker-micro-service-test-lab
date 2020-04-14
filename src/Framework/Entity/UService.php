<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\uServiceEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Framework\Repository\UServiceRepository")
 * @ORM\Table(name="u_service")
 */
class UService implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $movedToDir;

    public static function fromDomainEntity(uServiceEntity $uServiceEntity)
    {
        $entity = new self();
        $entity->setFile($uServiceEntity->file());
        $entity->setMovedToDir($uServiceEntity->movedToDir());
        $entity->setId($uServiceEntity->id());
        return $entity;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getMovedToDir(): ?string
    {
        return $this->movedToDir;
    }

    public function setMovedToDir(string $movedToDir): self
    {
        $this->movedToDir = $movedToDir;

        return $this;
    }

    public function id()
    {
        // TODO: Implement id() method.
    }


}
