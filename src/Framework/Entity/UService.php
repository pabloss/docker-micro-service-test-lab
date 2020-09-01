<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\uServiceEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unpacked;


    /**
     * @ORM\OneToMany(targetEntity="App\Framework\Entity\Test", mappedBy="UService")
     * @var PersistentCollection
     */
    private $tests;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uuid;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

    /**
     * @param uServiceEntity $uServiceEntity
     * @param UService|null  $frameworkEntity
     *
     * @return UService|null
     */
    public static function fromDomainEntity(uServiceEntity $uServiceEntity, ?self $frameworkEntity = null)
    {
        $entity = $frameworkEntity;
        if(null === $frameworkEntity){
            $entity = new self();
        }
        $entity->setFile($uServiceEntity->file());
        $entity->setMovedToDir($uServiceEntity->movedToDir());
        $entity->setId($uServiceEntity->id());
        $entity->setUnpacked($uServiceEntity->unpacked());
        $entity->setUuid($uServiceEntity->uuid());
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

    public function getUnpacked(): ?string
    {
        return $this->unpacked;
    }

    public function setUnpacked(?string $unpacked): self
    {
        $this->unpacked = $unpacked;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTests(): ArrayCollection
    {
        return new ArrayCollection($this->tests->toArray());
    }

    /**
     * @param Test $test
     *
     * @return $this
     */
    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setUService($this);
        }

        return $this;
    }

    /**
     * @param Test $product
     *
     * @return $this
     */
    public function removeTest(Test $product): self
    {
        if ($this->tests->contains($product)) {
            $this->tests->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getUService() === $this) {
                $product->setUService(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }
}
