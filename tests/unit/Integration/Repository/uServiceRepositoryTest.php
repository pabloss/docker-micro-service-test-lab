<?php namespace Integration\Repository;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use Integration\Stubs\PersistGateway;
use App\AppCore\Domain\Repository\uServiceEntity;
use App\AppCore\Domain\Repository\uServiceRepository;
use Codeception\Util\Autoload;

class uServiceRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/../Stubs/');
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        // Given
        $file = 'file';
        $movedToDir = 'movedToDir';
        $gateway = new PersistGateway();
        $repo = new uServiceRepository($gateway, new DomainEntityMapper());
        $domain = new uService($file, $movedToDir);

        // When
        $repo->persist($domain, $gateway->nextId());
        $all = $repo->all();
        $lastEntity = \end($all);

        // Then
        $this->tester->assertInstanceOf(uServiceEntity::class, $lastEntity);
        $this->tester->assertNotEmpty($lastEntity->id());
        $this->tester->assertEquals($movedToDir, $lastEntity->movedToDir());
        $this->tester->assertEquals($file, $lastEntity->getFile());

        $this->tester->assertEquals($domain, $repo->find($gateway->nextId()));
    }

    // tests
    public function testSomeFeatureWithNull()
    {
        // Given
        $file = 'file';
        $movedToDir = 'movedToDir';
        $gateway = new PersistGateway();
        $repo = new uServiceRepository($gateway, new DomainEntityMapper());
        $domain = new uService($file, $movedToDir);

        // When
        $repo->persist($domain, null);
        $all = $repo->all();
        $lastEntity = \end($all);

        // Then
        $this->tester->assertInstanceOf(uServiceEntity::class, $lastEntity);
        $this->tester->assertNotEmpty($lastEntity->id());
        $this->tester->assertEquals($movedToDir, $lastEntity->movedToDir());
        $this->tester->assertEquals($file, $lastEntity->getFile());

        $this->tester->assertEquals($domain, $repo->find($gateway->nextId()));
    }
}
