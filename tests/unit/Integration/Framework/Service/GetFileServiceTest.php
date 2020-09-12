<?php namespace Integration\Framework\Service;

use App\AppCore\Domain\Service\GetFileService;
use App\AppCore\Domain\Service\Save\SaveDomainService;
use App\Framework\Factory\EntityFactory;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class GetFileServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $uService;
    private $id;
    private $repo;

    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/../../Stubs/');
        // Given
        $this->id = 1;
        $file = 'test.txt';
        $movedToDir = 'dirName';
        $this->repo = new PersistGateway();
        $factory = new EntityFactory();
        $domainService = new SaveDomainService($movedToDir, $this->repo, $factory);

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
        $this->tester->assertEquals($this->uService->getMovedToDir(), $service->getService($this->id)->getMovedToDir());
        $this->tester->assertEquals($this->uService->getFile(), $service->getService($this->id)->getFile());
        $this->tester->assertEquals($this->uService->getUnpacked(), $service->getService($this->id)->getUnpacked());
    }
}
