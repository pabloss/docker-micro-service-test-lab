<?php

use App\AppCore\Domain\Actors\FileInterface;
use App\Framework\Files\UploadedFileAdapter;
use App\Framework\Service\SaveToFileSystemService;
use Integration\Stubs\File;

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
