<?php namespace App\AppCore\Domain\Service;


use App\AppCore\Domain\Repository\StatusEntity;
use App\AppCore\Domain\Service\Factory\EntityFactoryInterface;

class SaveStatusTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSave()
    {
        $uuid = '1111';
        $statusString = 'test_status';
        $uServiceId = 1;
        $now = new \DateTime('2020-08-14 12:33:45');

        $statusEntity = $this->prophesize(StatusEntity::class);
        $statusEntity->willBeConstructedWith([$uuid, $statusString, $now, $uServiceId]);

        $entityFactory = $this->prophesize(EntityFactoryInterface::class);
        $entityFactory->createStatusEntity($uuid, $statusString, $now)->willReturn($statusEntity->reveal())->shouldBeCalled();

        $statusRepo = $this->prophesize(StatusRepositoryInterface::class);
        $statusRepo->save($statusEntity->reveal())->shouldBeCalled();

        $service = new SaveStatus($statusRepo->reveal(), $entityFactory->reveal());

        $service->save($uuid, $statusString, $now);
    }
}
