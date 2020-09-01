<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Repository\TestEntity;
use App\AppCore\Domain\Actors\Test as DomainTest;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Framework\Repository\TestRepository")
 */
class Test
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string")
     */
    private $requestedBody;
    /**
     * @ORM\Column(type="string")
     */
    private $body;
    /**
     * @ORM\Column(type="string")
     */
    private $header;
    /**
     * @ORM\Column(type="string")
     */
    private $url;
    /**
     * @ORM\Column(type="string")
     */
    private $script;


    /**
     * @ORM\ManyToOne(targetEntity="App\Framework\Entity\UService", inversedBy="tests")
     */
    private $UService;

    public static function fromDomainEntity(TestEntity $testEntity, ?self $frameworkEntity = null)
    {
        $entity = $frameworkEntity;
        if(null === $frameworkEntity){
            $entity = new self();
        }
        $entity->setId($testEntity->id());
        $entity->setUuid($testEntity->uuid());
        $entity->setRequestedBody($testEntity->requestedBody());
        $entity->setBody($testEntity->body());
        $entity->setHeader($testEntity->header());
        $entity->setUrl($testEntity->url());
        $entity->setScript($testEntity->script());
        return $entity;
    }

    public static function asDomainEntity(self $entity)
    {
        return new TestEntity($entity->getUuid(), $entity->getRequestedBody(), $entity->getBody(), $entity->getHeader(), $entity->getScript(), $entity->getUrl(), $entity->getId());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Test
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    public function getRequestedBody(): ?string
    {
        return $this->requestedBody;
    }

    public function setRequestedBody(string $requestedBody): self
    {
        $this->requestedBody = $requestedBody;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUService()
    {
        return $this->UService;
    }

    /**
     * @param mixed $UService
     *
     * @return Test
     */
    public function setUService($UService)
    {
        $this->UService = $UService;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     *
     * @return Test
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     *
     * @return Test
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return Test
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param mixed $script
     *
     * @return Test
     */
    public function setScript($script)
    {
        $this->script = $script;
        return $this;
    }
}
