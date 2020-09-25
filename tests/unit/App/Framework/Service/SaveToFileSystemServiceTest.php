<?php

namespace App\Framework\Service;

use App\AppCore\Domain\Actors\FileInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Entity\Factory\EntityFactory;
use App\Framework\Entity\Status;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SaveToFileSystemServiceTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testMove()
    {
        $targetDir = 'test_dir';
        $uuid = "11111";
        $now = new \DateTime();
        $statusString = "file_moved";
        $uuidService = $this->prophesize(Uuid::class);
        $entityFactory = $this->prophesize(EntityFactory::class);
        $service = new SaveToFileSystemService(
            $this->prophesize(EventDispatcherInterface::class)->reveal(),
            $this->prophesize(uServiceRepositoryInterface::class)->reveal(),
            $entityFactory->reveal(),
            $uuidService->reveal(),
        );
        $status = new Status();
        $status->setUuid($uuid);
        $status->setStatusName($statusString);
        $status->setCreated($now);
        $entityFactory->createStatusEntity($uuid, $statusString, $now)->willReturn($status);
        $uuidService->getUuidFromDir("{$uuid}/$targetDir")->willReturn($uuid);
        $file = $this->prophesize(FileInterface::class);
        $file->move($targetDir)->willReturn($file->reveal());
        $file->getPath()->willReturn("{$uuid}/$targetDir/file.ext");
        $this->tester->assertInstanceOf(FileInterface::class, $service->move($targetDir, $file->reveal(), $now));
    }
}
