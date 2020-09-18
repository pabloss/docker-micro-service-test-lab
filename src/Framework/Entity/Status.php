<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Actors\StatusEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Framework\Repository\StatusRepository")
 */
class Status implements StatusEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Framework\Entity\UService", inversedBy="status")
     */
    private $UService;

    /**
     * @ORM\Column(type="string")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string")
     */
    private $statusName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getStatusName(): ?string
    {
        return $this->statusName;
    }

    public function setStatusName(string $statusName): self
    {
        $this->statusName = $statusName;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUService(): ?UService
    {
        return $this->UService;
    }

    public function setUService(?UService $UService): self
    {
        $this->UService = $UService;

        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function asArray(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'status_name' => $this->getStatusName(),
            'created' => $this->getCreated(),
        ];
    }

}
