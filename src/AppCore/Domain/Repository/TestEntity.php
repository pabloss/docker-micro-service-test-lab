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

    public function __construct(string $uuid, string $requestedBody, ?string $id)
    {
        $this->uuid = $uuid;
        $this->requestedBody = $requestedBody;
        $this->id = $id;
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
}
