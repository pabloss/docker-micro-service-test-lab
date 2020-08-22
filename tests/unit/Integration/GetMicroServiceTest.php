<?php namespace Integration;

use App\AppCore\Application\GetMicroServiceApplication;
use App\AppCore\Domain\Actors\Test;
use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\TestDomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class GetMicroServiceTest extends \Codeception\Test\Unit
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
        // 1. zakładając, że repo ma u-service w bazie op id = 1
        // 2. powinienem móc wziąć je z bazy
        // 3. i wyświetlić jego uuid
        // .. potem założyć, że u-service ma powiązania z innymi danymi i je też wyświetlić

        $uuid = '11111';
        $file = 'file';
        $movedToDir = 'movedToDir/'.$uuid;
        $requestedBody = 'requestedBody';
        $gateway = new PersistGateway();
        $repo = new uServiceRepository($gateway, new DomainEntityMapper(), new TestDomainEntityMapper());
        $domain = new uService($file, $movedToDir);
        $domainTest = new Test($uuid, $requestedBody);
        $domain->setTest($domainTest);
        $repo->persist($domain, $gateway->nextId());
        $application = new GetMicroServiceApplication($repo);

        // When
        $returnedDomain = $application->getUService($uuid);
        $returnedRequestedBody = $application->getTestRequestedBody($uuid);

        // Then
        $this->tester->assertNotEmpty($returnedDomain);
        $this->tester->assertInstanceOf(uService::class, $returnedDomain);
        $this->tester->assertEquals($file, $returnedDomain->file());
        $this->tester->assertEquals($movedToDir, $returnedDomain->movedToDir());
        $this->tester->assertNotEmpty($returnedRequestedBody);
        $this->tester->assertEquals($requestedBody, $returnedRequestedBody);
    }
}
