<?php namespace Integration;

use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\Unpack;

class UnpackTest extends \Codeception\Test\Unit
{
    const UNPACKED_DIR = __DIR__ . '/../../_data/unpacked/';
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        $this->tester->dir(self::UNPACKED_DIR);
    }

    // tests
    public function testUnzip()
    {

        // Given
        $service = new Unpack();
        $targetUnpackedDir = 'test';
        $zipFilePath = __DIR__ . '/../../_data/packed/test.zip';
        $this->tester->cleanDir(self::UNPACKED_DIR);
        $dirService = new Dir();
        $dirService->sureTargetDirExists(self::UNPACKED_DIR . $targetUnpackedDir);

        // When
        $service->unzip($zipFilePath, self::UNPACKED_DIR . $targetUnpackedDir);

        // Then
        $this->assertTrue(file_exists($zipFilePath));
        $this->assertTrue(file_exists(self::UNPACKED_DIR));
        $this->assertTrue(\is_dir(self::UNPACKED_DIR));
        $this->assertTrue(file_exists(self::UNPACKED_DIR . $targetUnpackedDir) && is_dir(self::UNPACKED_DIR . $targetUnpackedDir));

        // And
        // unpack it in test, scan target dir and compare file contents
        $zip = new \ZipArchive();
        $scanned_directory = array_diff(scandir(self::UNPACKED_DIR . $targetUnpackedDir), ['..', '.']);

        if ($zip->open($zipFilePath) === true) {
            $this->assertEquals($zip->numFiles, count($scanned_directory));
            foreach ($scanned_directory as $file) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    if ($file === $zip->getNameIndex($i)) {
                        // contents of files from scanned dir and unzipped files should be the same
                        // it could be custom assertion - for better readability
                        $this->assertEquals(sha1_file(self::UNPACKED_DIR . "/$targetUnpackedDir/" . $file),
                            sha1_file(self::UNPACKED_DIR . "/$targetUnpackedDir/" . $zip->getNameIndex($i)));
                    }
                }
            }
            $zip->close();
        }
    }

    public function testFailUnzip()
    {
        $service = new Unpack();

        // When
        $this->assertFalse($service->unzip(__FILE__, ''));
    }
}
