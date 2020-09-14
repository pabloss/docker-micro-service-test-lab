<?php namespace Integration;

use App\AppCore\Application\GetMicroServiceApplication;
use App\Framework\Factory\EntityFactory;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;
use Integration\Stubs\TestPersistGateway;

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
        $file = $uuid.'/file';
        $movedToDir = 'movedToDir/'.$uuid;
        $requestedBody = 'requestedBody';
        $gateway = new PersistGateway();
        $repo = $gateway;
        $factory = new EntityFactory();
        $domain = $factory->createService($file, $movedToDir);
        $domainTest = $factory->createTest($uuid, $requestedBody, 'body', 'header', 'url', 'script');
        $domain->addTest($domainTest);
        $repo->persist($domain, $gateway->nextId());
        $application = new GetMicroServiceApplication($repo, new TestPersistGateway());

        // When
        $returnedDomain = $application->getUService($uuid);
        $returnedRequestedBody = $application->getTestRequestedBody($uuid);

        // Then
        $this->tester->assertNotEmpty($returnedDomain);
        $this->tester->assertInstanceOf(\App\Framework\Entity\UService::class, $returnedDomain);
        $this->tester->assertEquals($file, $returnedDomain->getFile());
        $this->tester->assertEquals($movedToDir, $returnedDomain->getMovedToDir());
        $this->tester->assertNotEmpty($returnedRequestedBody);
        $this->tester->assertEquals($requestedBody, $returnedRequestedBody);
    }
}
