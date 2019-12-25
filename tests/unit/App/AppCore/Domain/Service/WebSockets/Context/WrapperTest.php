<?php namespace App\AppCore\Domain\Service\WebSockets\Context;

class WrapperTest extends \Codeception\Test\Unit
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
        $wrapper = new Wrapper();

        $wrapper->wrap([]);
    }
}
