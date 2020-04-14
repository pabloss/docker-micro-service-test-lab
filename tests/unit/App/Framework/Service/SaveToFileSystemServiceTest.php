<?php

namespace App\Framework\Service;

use App\AppCore\Domain\Actors\FileInterface;

class SaveToFileSystemServiceTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testMove()
    {
        $targetDir = 'test_dir';
        $service = new SaveToFileSystemService();
        $file = $this->prophesize(FileInterface::class);
        $file->move($targetDir)->willReturn($file->reveal());
        $this->tester->assertInstanceOf(FileInterface::class, $service->move($targetDir, $file->reveal()));
    }
}
