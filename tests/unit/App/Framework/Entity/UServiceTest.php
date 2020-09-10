<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Repository\uServiceEntity;

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
        $unpacked = 'unpacked';

        $domainEntity = $this->prophesize(uServiceEntity::class);
        $domainEntity->id()->willReturn($id);
        $domainEntity->getFile()->willReturn($file);
        $domainEntity->movedToDir()->willReturn($dir);
        $domainEntity->unpacked()->willReturn($unpacked);

        $entity = UService::fromDomainEntity($domainEntity->reveal(), null);

        $this->tester->assertEquals($id, $entity->getId());
        $this->tester->assertEquals($file, $entity->getFile());
        $this->tester->assertEquals($dir, $entity->getMovedToDir());
        $this->tester->assertEquals($unpacked, $entity->getUnpacked());
    }
}
