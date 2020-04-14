<?php

namespace Integration\App\AppCore\Application;

use App\AppCore\Application\DeployApplication;
use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\UnpackService;
use App\Framework\Service\UnpackAdapter;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class DeployApplicationTest extends \Codeception\Test\Unit
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR = __DIR__ . '/../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';
    const ZIPPED_TEST_UPLOAD_FILE_NAME = 'test.zip';
    const UNPACKED = 'unpacked';

    /**
     * @var \UnitTester
     */
    protected $tester;


    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__ . '/../../../../Integration/Stubs/');
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        /**
         * 1. Deploy application ma robić unppack
         *      - stosując zależność UnpackServiceInterface oraz Repo: rozpakuj (do nowej lokalizcji) i zapisz do bazy
         * 2. robić build
         */
        $id = 'id';
        // Given
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $application = new DeployApplication(
            new UnpackService(new UnpackAdapter(new \ZipArchive())),
            $repo
        ); //Framework

        // When
        $repo->persist(new uService(self::DATA_DIR . self::ZIPPED_TEST_UPLOAD_FILE_NAME, self::DATA_DIR));
        $application->deploy($id, self::DATA_DIR . self::UNPACKED . $id);

        // Then
        $this->tester->assertFileExists(self::DATA_DIR . self::UNPACKED . $id . '/' . self::TEST_UPLOAD_FILE_NAME);
        $this->tester->assertEquals(self::DATA_DIR . self::UNPACKED . $id, $repo->find($id)->unpacked());
    }
}
