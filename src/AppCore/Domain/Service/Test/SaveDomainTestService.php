<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Test;

use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\TestRepositoryInterface;

class SaveDomainTestService
{
    /**
     * @var TestRepositoryInterface
     */
    private $repository;

    /**
     * SaveDomainTestService constructor.
     *
     * @param TestRepositoryInterface $repository
     */
    public function __construct(TestRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(TestEntityInterface $test)
    {
        $this->repository->persist($test);
    }
}
