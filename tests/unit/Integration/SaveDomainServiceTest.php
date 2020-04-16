<?php namespace Integration;

use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\SaveDomainService;
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
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $domainService = new SaveDomainService($movedToDir, $repo);

        // When
        $domainService->save($file);
        /**
         * When I looked for last saved entity id I got also dir suffix
         */
        $all = $repo->all();

        // Then
        $this->tester->assertNotEmpty(\end($all)->id());
        $this->tester->assertEquals($movedToDir.$id, $repo->find($id)->movedToDir());
        $this->tester->assertEquals($file, $repo->find($id)->file());
    }
}
