<?php namespace Integration;

use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\PersistGateway;
use App\AppCore\Domain\Repository\uServiceEntity;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Repository\uServiceRepositoryTest;
use App\AppCore\Domain\SaveDomainService;
use App\Framework\Entity\MicroService;

class SaveDomainServiceTest extends \Codeception\Test\Unit
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
