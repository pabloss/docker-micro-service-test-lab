<?php
namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Actors\StatusEntityInterface;
use App\AppCore\Domain\Repository\StatusRepositoryInterface;
use App\AppCore\Domain\Service\Status\GetStatus;

class GetStatusTest extends \Codeception\Test\Unit
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
    public function testGet()
    {
        $uuid = '111111';
        $statusName = 'created';
        $created = new \DateTime('2020-08-12 12:45:33');
        $id = 1;

        $status = $this->prophesize(StatusEntityInterface::class);
        $status->getCreated()->willReturn($created);
        $status->getUuid()->willReturn($uuid);
        $status->getStatusName()->willReturn($statusName);
        $status->asArray()->willReturn(
            [
                'uuid' => $uuid,
                'status_name' => $statusName,
                'created' => $created,
            ]
        );

        $repo = $this->prophesize(StatusRepositoryInterface::class);
        $repo->get($id)->willReturn($status->reveal());
        $repo->findByHash($uuid)->willReturn([$status->reveal()]);

        $service = new GetStatus($repo->reveal());

        $this->tester->assertEquals($uuid, $service->getById($id)->getUuid());
        $this->tester->assertEquals($statusName, $service->getById($id)->getStatusName());
        $this->tester->assertEquals($created, $service->getById($id)->getCreated());
        $this->tester->assertEquals(
            [
                'uuid' => $uuid,
                'status_name' => $statusName,
                'created' => $created,
            ],
            $service->getById($id)->asArray()
        );

        $this->tester->assertEquals($uuid, $service->getByHash($uuid)[0]->getUuid());
        $this->tester->assertEquals($statusName, $service->getByHash($uuid)[0]->getStatusName());
        $this->tester->assertEquals($created, $service->getByHash($uuid)[0]->getCreated());
        $this->tester->assertEquals(
            [
                'uuid' => $uuid,
                'status_name' => $statusName,
                'created' => $created,
            ],
            $service->getByHash($uuid)[0]->asArray()
        );

    }
}
