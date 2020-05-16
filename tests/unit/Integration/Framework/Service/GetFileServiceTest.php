<?php namespace Integration\Framework\Service;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\GetFileService;
use App\AppCore\Domain\Service\Save\SaveDomainService;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class GetFileServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @var uService
     */
    private $uService;
    private $id;
    private $repo;

    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/../../Stubs/');
        // Given
        $this->id = 'id';
        $file = 'test.txt';
        $movedToDir = 'dirName';
        $this->repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $domainService = new SaveDomainService($movedToDir, $this->repo);

        // When
        $this->uService = $domainService->save($file);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $service = new GetFileService($this->repo);
        $this->tester->assertEquals($this->uService, $service->getService($this->id));
    }
}
