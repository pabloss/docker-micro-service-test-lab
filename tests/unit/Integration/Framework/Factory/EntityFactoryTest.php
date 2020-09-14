<?php namespace Integration\Framework\Factory;

use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\uServiceEntityInterface;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
use App\Framework\Factory\EntityFactory;

class EntityFactoryTest extends \Codeception\Test\Unit
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
        $factory = new EntityFactory();

        $file = 'file';
        $movedToDir = 'dir';
        $this->tester->assertInstanceOf(uServiceEntityInterface::class, $factory->createService($file, $movedToDir));
        $this->tester->assertInstanceOf(UService::class, $factory->createService($file, $movedToDir));
        $this->tester->assertEquals($file, $factory->createService($file, $movedToDir)->getFile());
        $this->tester->assertEquals($movedToDir, $factory->createService($file, $movedToDir)->getMovedToDir());
    }


    // tests
    public function testCreationTest()
    {
        $factory = new EntityFactory();

        $file = 'file';
        $movedToDir = 'dir';
        $uuid = 'uuid';
        $script = 'script';
        $url = 'url';
        $header = 'header';
        $body = 'body';
        $requestedBody = 'requested_body';
        $this->tester->assertInstanceOf(
            TestEntityInterface::class,
            $factory->createTest(
                $uuid,
                $requestedBody,
                $body,
                $header,
                $url,
                $script
            )
        );
        $this->tester->assertInstanceOf(
            Test::class,
            $factory->createTest(
                $uuid,
                $requestedBody,
                $body,
                $header,
                $url,
                $script
            )
        );
        $this->tester->assertEquals($uuid, $factory->createTest(
            $uuid,
            $requestedBody,
            $body,
            $header,
            $url,
            $script
        )->getUuid());
        $this->tester->assertEquals($script, $factory->createTest(
            $uuid,
            $requestedBody,
            $body,
            $header,
            $url,
            $script
        )->getScript());
    }
}
