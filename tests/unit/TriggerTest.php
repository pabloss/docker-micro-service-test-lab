<?php

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Service\Trigger;
use GuzzleHttp\Middleware;

class TriggerTest extends \Codeception\Test\Unit
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
        $trigger = new Trigger();

//        $uService = new uService(\dirname(__FILE__, 3).'/_data/packed/guzzle-client.zip', '');

        $uService = $this->prophesize(uService::class);
        $uService->unpacked()->willReturn(\dirname(__FILE__, 2).'/_data/unpacked/guzzle-client/')->shouldBeCalled();
        // weź musługe
        // wyzwól żądanie
        // zakładamy że można łatwo wyzwolić
        // do żądania dodaj header => middleware?

        /**
         * Buduj obraz
         * Uruchom kontener
         */

        /**
         * W tym celu
         * stwórz taki docker
         */

        $trigger->runRequest($uService->reveal(), "image_prefix_xxxx", "container_prefix_xxxx",);
    }
}
