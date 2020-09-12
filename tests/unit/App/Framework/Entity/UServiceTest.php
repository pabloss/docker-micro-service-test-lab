<?php

namespace App\Framework\Entity;

use App\AppCore\Domain\Repository\uServiceEntityInterface;

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

        $entity = new UService();
        $entity->setId($id);
        $entity->setFile($file);
        $entity->setMovedToDir($dir);
        $entity->setUnpacked($unpacked);

        $this->tester->assertInstanceOf(uServiceEntityInterface::class, $entity);
        $this->tester->assertEquals($id, $entity->getId());
        $this->tester->assertEquals($file, $entity->getFile());
        $this->tester->assertEquals($dir, $entity->getMovedToDir());
        $this->tester->assertEquals($unpacked, $entity->getUnpacked());
    }
}
