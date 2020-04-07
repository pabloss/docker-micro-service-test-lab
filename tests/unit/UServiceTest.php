<?php

use App\AppCore\Domain\Repository\uServiceEntity;
use App\Framework\Entity\UService;

class UServiceTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreateFromDomainEntity()
    {

        $id = 1;
        $file = 'test';
        $dir = 'test_dir';

        $domainEntity = $this->prophesize(uServiceEntity::class);
        $domainEntity->id()->willReturn($id);
        $domainEntity->file()->willReturn($file);
        $domainEntity->movedToDir()->willReturn($dir);

        $entity = UService::fromDomainEntity($domainEntity->reveal());

        $this->tester->assertEquals($id, $entity->getId());
        $this->tester->assertEquals($file, $entity->getFile());
        $this->tester->assertEquals($dir, $entity->getMovedToDir());
    }
}
