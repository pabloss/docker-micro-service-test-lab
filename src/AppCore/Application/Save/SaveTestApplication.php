<?php
declare(strict_types=1);

namespace App\AppCore\Application\Save;

use App\AppCore\Domain\Actors\Test;
use App\AppCore\Domain\Service\SaveDomainTestService;
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

    public function __construct(SaveDomainTestService $service, TestRepository $testRepository)
    {
        $this->service = $service;
        $this->testRepository = $testRepository;
    }

    public function save(array $data)
    {
        if(null === ($testEntity = $this->testRepository->findOneBy(['uuid' => $data['uuid']]))) {
            $this->service->save(new Test($data['uuid'], $data['test'], $data['body'], $data['header'], $data['script'], $data['url']), null);
        } else {
            $this->service->save(new Test($data['uuid'], $data['test'], $data['body'], $data['header'], $data['script'], $data['url']), (string) $testEntity->getId());
        }


    }
}
