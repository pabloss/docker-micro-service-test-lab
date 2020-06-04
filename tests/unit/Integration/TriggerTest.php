<?php namespace Integration;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Service\Trigger;

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

        $uService = new uService(\dirname(__FILE__, 3).'/_data/packed/guzzle-client.zip', '');
        $uService->setUnpacked(\dirname(__FILE__, 3).'/_data/unpacked/guzzle-client/');


        /**
         * W tym celu
         * stwórz taki docker
         */

        $trigger->runRequest($uService, "image_prefix_xxxx", "container_prefix_xxxx",);
    }
}
