<?php

namespace App\Tests\AppCore\Application\Save;

use App\AppCore\Application\Save\SaveTestApplication;
use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Service\SaveDomainTestService;
use App\AppCore\Domain\Service\UpdateTestService;
use App\Framework\Entity\Test;

class SaveTestApplicationTest extends \Codeception\Test\Unit
{

    public function testSave()
    {
        $id = '1';
        $uuid = '1111';
        $requestedBody = 'test_requested_body';
        $body = 'test_body';
        $header = 'test_header';
        $url = 'test_url';
        $script = 'test_script';
        $data = [
            'uuid' => $uuid,
            'requested_body' => $requestedBody,
            'body' => $body,
            'header' => $header,
            'url' => $url,
            'script' => $script,
        ];
        $testEntity = $this->prophesize(Test::class);
        $testEntity->willImplement(TestEntityInterface::class);
        $testEntity->getId()->willReturn($id)->shouldBeCalled();
        $testEntity->setUrl($url)->shouldBeCalled();
        $testEntity->setUuid($uuid)->shouldBeCalled();
        $testEntity->setScript($script)->shouldBeCalled();
        $testEntity->setHeader($header)->shouldBeCalled();
        $testEntity->setBody($body)->shouldBeCalled();
        $testEntity->setRequestedBody($requestedBody)->shouldBeCalled();

        $testRepository = $this->prophesize(TestRepositoryInterface::class);
        $testRepository->findByHash($uuid)->willReturn($testEntity->reveal())->shouldBeCalled();

        $updateTestService = $this->prophesize(UpdateTestService::class);
        $updateTestService->update($testEntity->reveal(), $data)->will(function ($args){
            $test = $args[0];
            $data = $args[1];
            $test->setUuid($data['uuid']);
            $test->setUrl($data['url']);
            $test->setScript($data['script']);
            $test->setHeader($data['header']);
            $test->setBody($data['body']);
            $test->setRequestedBody($data['requested_body']);

            return $test;
        });

        $factory = $this->prophesize(EntityFactoryInterface::class);

        $saveDomainTestService = $this->prophesize(SaveDomainTestService::class);
        $saveDomainTestService->save($testEntity->reveal(), $id)->shouldBeCalled();
        $application = new SaveTestApplication($saveDomainTestService->reveal(), $testRepository->reveal(), $factory->reveal(), $updateTestService->reveal());

        $application->save($data);

    }
}
