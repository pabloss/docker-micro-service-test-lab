<?php namespace App\MixedContext\Domain\Service\Files;

class FileTest extends \Codeception\Test\Unit
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
        $file = new File();
        $this->assertEquals(explode('.', \basename(__FILE__))[0], $file->getBasenameWithoutExtension(__FILE__));
        $this->assertEquals(false, $file->isMimeTypeOf('', __FILE__));
    }
}
