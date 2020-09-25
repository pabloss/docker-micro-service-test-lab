<?php
declare(strict_types=1);

namespace App\AppCore\Application\Save;

use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Service\SaveDomainTestService;
use App\AppCore\Domain\Service\UpdateTestService;

class SaveTestApplication
{
    /**
     * @var SaveDomainTestService
     */
    private $service;
    /**
     * @var TestRepositoryInterface
     */
    private $testRepository;
    /**
     * @var EntityFactoryInterface
     */
    private $entityFactory;
    /**
     * @var UpdateTestService
     */
    private $updateTestService;

    /**
     * SaveTestApplication constructor.
     *
     * @param SaveDomainTestService   $service
     * @param TestRepositoryInterface $testRepository
     * @param EntityFactoryInterface  $entityFactory
     * @param UpdateTestService       $updateTestService
     */
    public function __construct(SaveDomainTestService $service, TestRepositoryInterface $testRepository, EntityFactoryInterface $entityFactory, UpdateTestService $updateTestService)
    {
        $this->service = $service;
        $this->testRepository = $testRepository;
        $this->entityFactory = $entityFactory;
        $this->updateTestService = $updateTestService;
    }

    public function save(TestDTO $testDTO)
    {
        if(null === ($testEntity = $this->testRepository->findByHash($testDTO->getUuid()))) {
            $this->service->save(
                $this->entityFactory->createTest($testDTO), null
            );
        } else {
            $this->service->save(
                $this->updateTestService->update($testEntity, $testDTO),
                (string) $testEntity->getId()
            );
        }


    }
}
