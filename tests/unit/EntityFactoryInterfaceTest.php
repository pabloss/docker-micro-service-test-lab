<?php

namespace App\Tests;

use App\AppCore\Domain\Actors\TestDTO;
use App\Framework\Entity\Factory\EntityFactory;
use App\Framework\Entity\Test;

class EntityFactoryInterfaceTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreateTest()
    {
        $factory = new EntityFactory();
        $uuid = '';
        $requestedBody = '';
        $body = '';
        $header = '';
        $url = '';
        $script = '';

        $testDTO = new TestDTO(
            $uuid,
            $requestedBody,
            $body,
            $header,
            $url,
            $script
        );
        $test = new Test();
        $test->setUuid($uuid);
        $test->setUrl($url);
        $test->setBody($body);
        $test->setRequestedBody($requestedBody);
        $test->setScript($script);
        $test->setHeader($header);
        $this->tester->assertEquals($test, $factory->createTest($testDTO));
    }
}
