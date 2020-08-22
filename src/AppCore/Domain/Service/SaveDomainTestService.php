<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Actors\Test;
use App\AppCore\Domain\Repository\TestRepository;

class SaveDomainTestService
{
    /**
     * @var TestRepository
     */
    private $repository;

    /**
     * SaveDomainTestService constructor.
     *
     * @param TestRepository $repository
     */
    public function __construct(TestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(Test $test, ?string $id)
    {
        $this->repository->persist($test, $id);
    }
}
