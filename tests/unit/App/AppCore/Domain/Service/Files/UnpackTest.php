<?php namespace App\AppCore\Domain\Service\Files;

class UnpackTest extends \Codeception\Test\Unit
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
        $unpack = new Unpack();
        $this->assertEquals('/home/pavulon/code/docker-micro-service-test-lab-new/tests/unit/App/AppCore/Domain/Service/Files/UnpackTest', $unpack->getTargetDir(\dirname(__FILE__), __FILE__));
    }
}
