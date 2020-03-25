<?php namespace App\Framework\Factory;

use App\AppCore\Application\UploadedFileFactoryInterface;
use App\AppCore\Domain\Actors\UploadedFileInterface;

class UploadedFileFactoryTest extends \Codeception\Test\Unit
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
    public function testSomeFeature()
    {
        $fileToSave = __DIR__ . '/../../../../_data/save_test';
        $factory = new UploadedFileFactory();

        $this->tester->assertInstanceOf(UploadedFileFactoryInterface::class, $factory);
        $this->tester->assertInstanceOf(UploadedFileInterface::class, $factory->createUploadedFile($fileToSave));
    }
}
