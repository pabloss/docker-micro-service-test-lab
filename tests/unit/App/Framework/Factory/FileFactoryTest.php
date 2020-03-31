<?php namespace App\Framework\Factory;

use App\AppCore\Application\FileFactoryInterface;
use App\AppCore\Domain\Actors\FileInterface;

class FileFactoryTest extends \Codeception\Test\Unit
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
        $factory = new FileFactory();

        $this->tester->assertInstanceOf(FileFactoryInterface::class, $factory);
        $this->tester->assertInstanceOf(FileInterface::class, $factory->createFile($fileToSave));
    }
}
