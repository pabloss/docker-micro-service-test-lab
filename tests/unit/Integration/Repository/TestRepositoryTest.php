<?php namespace Integration\Repository;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\Framework\Entity\Test;
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
        $repo = new TestPersistGateway();
        $domain = new Test();
        $domain->setUuid($uuid);
        $domain->setRequestedBody($requestedBody);

        // When
        $repo->persist($domain, $repo->nextId());
        $all = $repo->all();
        $lastEntity = \end($all);

        // Then
        $this->tester->assertInstanceOf(TestRepositoryInterface::class, $repo);
        $this->tester->assertInstanceOf(Test::class, $lastEntity);
        $this->tester->assertNotEmpty($lastEntity->getId());
        $this->tester->assertEquals($uuid, $lastEntity->getUuid());
        $this->tester->assertEquals($requestedBody, $lastEntity->getRequestedBody());

        $this->tester->assertEquals($domain, $repo->find($repo->nextId()));
        $this->tester->assertEquals($domain, $repo->findByHash($uuid));
    }
}
