<?php namespace Integration;

use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\Save\SaveDomainService;
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
        $movedToDir = 'parentDirName/dirName';
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $domainService = new SaveDomainService($movedToDir, $repo);

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
        $this->tester->assertEquals($movedToDir,\end($all)->movedToDir());
        $this->tester->assertEquals($file, \end($all)->file());
        $this->tester->assertEquals($matches[0], \end($all)->uuid());
    }

    // tests
    public function testOneLevelDirTreee()
    {
        // Given
        $id = 'id';
        $file = 'test.txt';
        $movedToDir = '/';
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $domainService = new SaveDomainService($movedToDir, $repo);

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
        $this->tester->assertEquals($movedToDir,\end($all)->movedToDir());
        $this->tester->assertEquals($file, \end($all)->file());
        $this->tester->assertEquals($matches[0], \end($all)->uuid());
    }
}
