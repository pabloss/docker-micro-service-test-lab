<?php
namespace Integration;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Service\Build\Unpack\UnpackService;
use App\AppCore\Domain\Service\Build\Unpack\UnpackServiceInterface;
use App\Framework\Service\UnpackAdapter;

class UnpackServiceTest extends \Codeception\Test\Unit
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR =   '/../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';
    const ZIPPED_TEST_UPLOAD_FILE_NAME = 'test.zip';

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
        $id = 'id';
        $unpackedDir = 'unpacked';
        $domainUService = new uService(self::DATA_DIR.self::ZIPPED_TEST_UPLOAD_FILE_NAME, self::DATA_DIR);

        $unpackLibAdapter = new UnpackAdapter(new \ZipArchive());
        $service = new UnpackService($unpackLibAdapter);
        $updatedUService = $service->unpack($domainUService, self::DATA_DIR.$unpackedDir.$id);

        $this->tester->assertInstanceOf(UnpackServiceInterface::class, $service);
        $this->tester->assertStringStartsWith(self::DATA_DIR.$unpackedDir.$id, $updatedUService->getUnpacked());
    }
}
