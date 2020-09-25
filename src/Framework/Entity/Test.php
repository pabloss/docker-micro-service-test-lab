<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Repository\TestEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Framework\Repository\TestRepository")
 */
class Test implements TestEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
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

    /**
     * @param Test $test
     *
     * @return array
     */
    public static function asArray(self $test)
    {
        return [
            'uuid' => $test->getUuid(),
            'url' => $test->getUrl(),
            'script' => $test->getScript(),
            'header' => $test->getHeader(),
            'requested_body' => $test->getRequestedBody(),
            'body' => $test->getBody(),
        ];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl(): string
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
    public function getScript(): string
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

    /**
     * @return mixed
     */
    public function getHeader(): string
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

    public function getRequestedBody(): string
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
    public function getBody(): string
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

    public function getId()
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
}
