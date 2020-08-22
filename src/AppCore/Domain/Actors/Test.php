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
    private $requestedBody;

    /**
     * Test constructor.
     *
     * @param string $uuid
     * @param string $requestedBody
     */
    public function __construct(string $uuid, string $requestedBody)
    {
        $this->uuid = $uuid;
        $this->requestedBody = $requestedBody;
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

}
