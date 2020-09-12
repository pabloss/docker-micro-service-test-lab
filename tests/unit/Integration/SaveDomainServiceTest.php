<?php namespace Integration;

use App\AppCore\Domain\Service\Save\SaveDomainService;
use App\Framework\Factory\EntityFactory;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class SaveDomainServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/Stubs/');
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        // Given
        $id = 'id';
        $file = 'test.txt';
        $movedToDir = 'dirName';
        $repo = new PersistGateway();
        $domainService = new SaveDomainService($movedToDir, $repo, new EntityFactory());

        // When
        $domainService->save($file);
        /**
         * When I looked for last saved entity id I got also dir suffix
         */
        $all = $repo->all();

        \preg_match('/(\w+)$/', $movedToDir, $matches);


        if(\count($matches) < 2){
            $matches = ['/'];
        }
        // Then
        $this->tester->assertEquals($movedToDir,\end($all)->getMovedToDir());
        $this->tester->assertEquals($file, \end($all)->getFile());
    }
}
