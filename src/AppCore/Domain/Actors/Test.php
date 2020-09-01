<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

class Test
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $script;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $requestedBody;

    /**
     * Test constructor.
     *
     * @param string $uuid
     * @param string $requestedBody
     * @param string $body
     * @param string $header
     * @param string $script
     * @param string $url
     */
    public function __construct(string $uuid, string $requestedBody, string $body, string $header, string $script , string $url)
    {
        $this->uuid = $uuid;
        $this->requestedBody = $requestedBody;
        $this->body = $body;
        $this->header = $header;
        $this->script = $script;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return Test
     */
    public function setUuid(string $uuid): Test
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestedBody(): string
    {
        return $this->requestedBody;
    }

    /**
     * @param string $requestedBody
     *
     * @return Test
     */
    public function setRequestedBody(string $requestedBody): Test
    {
        $this->requestedBody = $requestedBody;
        return $this;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * @param string $script
     *
     * @return Test
     */
    public function setScript(string $script): Test
    {
        $this->script = $script;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Test
     */
    public function setUrl(string $url): Test
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     *
     * @return Test
     */
    public function setHeader(string $header): Test
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return Test
     */
    public function setBody(string $body): Test
    {
        $this->body = $body;
        return $this;
    }

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
}
