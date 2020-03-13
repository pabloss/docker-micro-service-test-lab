<?php namespace Integration\Repository;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\PersistGateway;
use App\AppCore\Domain\Repository\uServiceEntity;
use App\AppCore\Domain\Repository\uServiceRepository;

class uServiceRepositoryTest extends \Codeception\Test\Unit
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
        $file = 'file';
        $movedToDir = 'movedToDir';
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $domain = new uService($file, $movedToDir);

        // When
        $repo->persist($domain);
        $all = $repo->all();
        $lastEntity = \end($all);

        // Then
        $this->tester->assertInstanceOf(uServiceEntity::class, $lastEntity);
        $this->tester->assertNotEmpty($lastEntity->id());
        $this->tester->assertEquals($movedToDir.$lastEntity->id(), $lastEntity->movedToDir());
        $this->tester->assertEquals($file, $lastEntity->file());
    }
}
