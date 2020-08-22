<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Repository\uServiceRepositoryInterface;

class GetMicroServiceApplication
{
    /**
     * @var uServiceRepositoryInterface
     */
    private $repository;

    /**
     * GetMicroService constructor.
     *
     * @param uServiceRepositoryInterface $repository
     */
    public function __construct(uServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUService(string $uuid)
    {
        return $this->repository->findByHash($uuid);
    }

    public function getTestRequestedBody(string $uuid)
    {
        return $this->repository->findByHash($uuid)->getTest()->getRequestedBody();
    }
}
