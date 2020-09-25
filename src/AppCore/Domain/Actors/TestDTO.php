<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

class TestDTO
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
    private $url;
    /**
     * @var string
     */
    private $script;

    /**
     * TestDTO constructor.
     *
     * @param string $uuid
     * @param string $requestedBody
     * @param string $body
     * @param string $header
     * @param string $url
     * @param string $script
     */
    public function __construct(
        string $uuid,
        string $requestedBody,
        string $body,
        string $header,
        string $url,
        string $script
    ) {
        $this->uuid = $uuid;
        $this->requestedBody = $requestedBody;
        $this->body = $body;
        $this->header = $header;
        $this->url = $url;
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getRequestedBody(): string
    {
        return $this->requestedBody;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }
}
