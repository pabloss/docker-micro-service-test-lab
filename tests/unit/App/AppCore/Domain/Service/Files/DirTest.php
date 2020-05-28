<?php namespace App\Framework\Files;

class DirTest extends \Codeception\Test\Unit
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
        $dir = new Dir();
        $this->assertEquals(__FILE__, $dir->findFile(\dirname(__FILE__, 2), \basename(__FILE__)));
        $this->assertEquals(__FILE__, $dir->findFile(__DIR__, \basename(__FILE__)));
        $this->assertEquals(__DIR__, $dir->findParentDir(__DIR__, \basename(__FILE__)));
    }
}
