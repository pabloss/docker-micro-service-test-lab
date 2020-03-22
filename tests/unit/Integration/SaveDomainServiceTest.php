<?php namespace Integration;

use App\AppCore\Domain\Repository\DomainEntityMapper;
use Integration\Stubs\PersistGateway;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\SaveDomainService;
use Codeception\Util\Autoload;

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
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $domainService = new SaveDomainService($movedToDir, $repo);

        // When
        $uService = $domainService->save($file);
        /**
         * When I looked for last saved entity id I got also dir suffix
         */
        $all = $repo->all();

        // Then
        $this->tester->assertNotEmpty(\end($all)->id());
        $this->tester->assertEquals($movedToDir, $uService->movedToDir());
        $this->tester->assertEquals($file, $uService->fileName());
    }
}
