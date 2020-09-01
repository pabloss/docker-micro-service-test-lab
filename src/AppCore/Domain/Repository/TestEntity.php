<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

class TestEntity implements EntityInterface
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var string
     */
    private $requestedBody;
    /**
     * @var string|null
     */
    private $id;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string
     */
    private $header;
    /**
     * @var string
     */
    private $script;
    /**
     * @var string
     */
    private $url;

    public function __construct(string $uuid, string $requestedBody, string $body, string $header, string $script , string $url, ?string $id)
    {
        $this->uuid = $uuid;
        $this->requestedBody = $requestedBody;
        $this->id = $id;
        $this->body = $body;
        $this->header = $header;
        $this->script = $script;
        $this->url = $url;
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function requestedBody(): string
    {
        return $this->requestedBody;
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function header(): string
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return $this->script;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }
}
