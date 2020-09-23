<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;

class UpdateTestService
{
    /**
     * @var uServiceRepositoryInterface
     */
    private $uServiceRepository;

    public function __construct(uServiceRepositoryInterface $uServiceRepository)
    {
        $this->uServiceRepository = $uServiceRepository;
    }

    public function update(TestEntityInterface $test, array $data): TestEntityInterface
    {
        $test->setUuid($data['uuid']);
        $test->setUrl($data['url']);
        $test->setScript($data['script']);
        $test->setHeader($data['header']);
        $test->setBody($data['body']);
        $test->setRequestedBody($data['requested_body']);
        $test->setUService(
            $this->uServiceRepository->findByHash($data['uuid'])
        );
        return $test;
    }
}
