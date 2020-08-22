<?php namespace Integration;

use App\AppCore\Domain\Actors\Test;
use App\AppCore\Domain\Repository\TestDomainEntityMapper;
use App\AppCore\Domain\Repository\TestRepository;
use App\AppCore\Domain\Service\SaveDomainTestService;
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
        $test = new Test($uuid, $requestedBody);
        $repo = new TestRepository(new TestPersistGateway(), new TestDomainEntityMapper());
        $domainService = new SaveDomainTestService($repo);

        // When
        $domainService->save($test, null);

        // Then
        $all = $repo->all();

        $last = \end($all);
        $this->tester->assertEquals($test->getRequestedBody(), $last->requestedBody());
        $this->tester->assertEquals($test->getUuid(), $last->uuid());

    }

    // tests
    public function testSavingWithId()
    {
        // Given
        $id = 'IDD';
        $uuid = '111111';
        $requestedBody = 'requestedBody';
        $test = new Test($uuid, $requestedBody);
        $repo = new TestRepository(new TestPersistGateway(), new TestDomainEntityMapper());
        $domainService = new SaveDomainTestService($repo);

        // When
        $domainService->save($test, $id);

        // Then
        $all = $repo->all();

        $last = \end($all);
        $this->tester->assertEquals($id, $last->id());
        $this->tester->assertEquals($test->getRequestedBody(), $last->requestedBody());
        $this->tester->assertEquals($test->getUuid(), $last->uuid());

    }
}
