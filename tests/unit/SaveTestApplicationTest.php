<?php

namespace App\Tests\AppCore\Application\Save;

use App\AppCore\Application\Save\SaveTestApplication;
use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Actors\TestDTO;
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

        $testDTO = $this->prophesize(TestDTO::class);
        $testDTO->getScript()->willReturn($script);
        $testDTO->getHeader()->willReturn($header);
        $testDTO->getBody()->willReturn($body);
        $testDTO->getRequestedBody()->willReturn($requestedBody);
        $testDTO->getUrl()->willReturn($url);
        $testDTO->getUuid()->willReturn($uuid);

        $updateTestService = $this->prophesize(UpdateTestService::class);
        $updateTestService->update($testEntity->reveal(), $testDTO->reveal())->will(function ($args){
            $test = $args[0];
            /** @var TestDTO $testDTO */
            $testDTO = $args[1];
            $test->setUuid($testDTO->getUuid());
            $test->setUrl($testDTO->getUrl());
            $test->setScript($testDTO->getScript());
            $test->setHeader($testDTO->getHeader());
            $test->setBody($testDTO->getBody());
            $test->setRequestedBody($testDTO->getRequestedBody());

            return $test;
        });

        $factory = $this->prophesize(EntityFactoryInterface::class);
        $factory->createTest($testDTO->reveal())->willReturn($testEntity->reveal())->shouldBeCalled();

        $saveDomainTestService = $this->prophesize(SaveDomainTestService::class);
        $saveDomainTestService->save($testEntity->reveal(), $id)->shouldBeCalled();
        $application = new SaveTestApplication($saveDomainTestService->reveal(), $testRepository->reveal(), $factory->reveal(), $updateTestService->reveal());

        $application->save($testDTO->reveal());

        $testRepository->findByHash($uuid)->willReturn(null)->shouldBeCalled();
        $saveDomainTestService->save($testEntity->reveal(), null)->shouldBeCalled();
        $application->save($testDTO->reveal());
    }
}
