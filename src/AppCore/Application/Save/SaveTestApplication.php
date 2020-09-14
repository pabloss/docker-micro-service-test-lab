<?php
declare(strict_types=1);

namespace App\AppCore\Application\Save;

use App\AppCore\Domain\Service\SaveDomainTestService;
use App\Framework\Factory\EntityFactory;
use App\Framework\Repository\TestRepository;

class SaveTestApplication
{
    /**
     * @var SaveDomainTestService
     */
    private $service;
    /**
     * @var TestRepository
     */
    private $testRepository;
    /**
     * @var EntityFactory
     */
    private $entityFactory;

    /**
     * SaveTestApplication constructor.
     *
     * @param SaveDomainTestService $service
     * @param TestRepository        $testRepository
     * @param EntityFactory         $entityFactory
     */
    public function __construct(SaveDomainTestService $service, TestRepository $testRepository, EntityFactory $entityFactory)
    {
        $this->service = $service;
        $this->testRepository = $testRepository;
        $this->entityFactory = $entityFactory;
    }

    public function save(array $data)
    {
        if(null === ($testEntity = $this->testRepository->findOneBy(['uuid' => $data['uuid']]))) {
            $this->service->save($this->entityFactory->createTest($data['uuid'], $data['test'], $data['body'], $data['header'], $data['url'], $data['script']), null);
        } else {
            $this->service->save($this->entityFactory->createTest($data['uuid'], $data['test'], $data['body'], $data['header'], $data['url'], $data['script']), (string) $testEntity->getId());
        }


    }
}
