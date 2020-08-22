<?php namespace Integration\Repository;

use App\AppCore\Domain\Actors\Test;
use App\AppCore\Domain\Repository\TestDomainEntityMapper;
use App\AppCore\Domain\Repository\TestEntity;
use App\AppCore\Domain\Repository\TestRepository;
use Codeception\Util\Autoload;
use Integration\Stubs\TestPersistGateway;

class TestRepositoryTest extends \Codeception\Test\Unit
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

        $uuid = '111';
        $requestedBody = 'test_body';
        $gateway = new TestPersistGateway();
        $mapper = new TestDomainEntityMapper();
        $repo = new TestRepository($gateway, $mapper);
        $domain = new Test($uuid, $requestedBody);

        // When
        $repo->persist($domain, $gateway->nextId());
        $all = $repo->all();
        $lastEntity = \end($all);

        // Then
        $this->tester->assertInstanceOf(TestEntity::class, $lastEntity);
        $this->tester->assertNotEmpty($lastEntity->id());
        $this->tester->assertEquals($uuid, $lastEntity->uuid());
        $this->tester->assertEquals($requestedBody, $lastEntity->requestedBody());

        $this->tester->assertEquals($domain, $repo->find($gateway->nextId()));
        $this->tester->assertEquals($domain, $repo->findByHash($uuid));
    }
}
