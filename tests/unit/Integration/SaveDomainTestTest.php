<?php namespace Integration;

use App\AppCore\Domain\Service\SaveDomainTestService;
use App\Framework\Factory\EntityFactory;
use Codeception\Util\Autoload;
use Integration\Stubs\TestPersistGateway;

class SaveDomainTestTest extends \Codeception\Test\Unit
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
    public function testSavingWithNullId()
    {
        // Given
        $uuid = '111111';
        $requestedBody = 'requestedBody';
        $factory = new EntityFactory();
        $test = $factory->createTest($uuid, $requestedBody, '', '', '', '');
        $repo = new TestPersistGateway();
        $domainService = new SaveDomainTestService($repo);

        // When
        $domainService->save($test, null);

        // Then
        $all = $repo->all();

        $last = \end($all);
        $this->tester->assertEquals($test->getRequestedBody(), $last->getRequestedBody());
        $this->tester->assertEquals($test->getUuid(), $last->getUuid());

    }

    // tests
    public function testSavingWithId()
    {
        // Given
        $id = 'id';
        $uuid = '111111';
        $requestedBody = 'requestedBody';
        $factory = new EntityFactory();
        $test = $factory->createTest($uuid, $requestedBody, '', '', '', '');
        $repo = new TestPersistGateway();
        $domainService = new SaveDomainTestService($repo);

        // When
        $domainService->save($test, $id);

        // Then
        $all = $repo->all();

        $last = \end($all);
        $this->tester->assertEquals($id, $last->getId());
        $this->tester->assertEquals($test->getRequestedBody(), $last->getRequestedBody());
        $this->tester->assertEquals($test->getUuid(), $last->getUuid());

    }
}
