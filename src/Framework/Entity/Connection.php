<?php

namespace App\Framework\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Framework\Repository\ConnectionRepository")
 */
class Connection
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
    private $uuid1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uuid2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid1(): ?string
    {
        return $this->uuid1;
    }

    public function setUuid1(string $uuid1): self
    {
        $this->uuid1 = $uuid1;

        return $this;
    }

    public function getUuid2(): ?string
    {
        return $this->uuid2;
    }

    public function setUuid2(string $uuid2): self
    {
        $this->uuid2 = $uuid2;

        return $this;
    }
}
