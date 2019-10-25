<?php namespace Integration;

use App\Files\Unpack;

class UnpackTest extends \Codeception\Test\Unit
{
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
    public function testUnzip()
    {

        // Given
        $service = new Unpack();
        $zipFilePath = __DIR__ . '/../../_data/packed/test.zip';
        $dirName = __DIR__ . '/../../_data/unpacked/';
        $this->tester->cleanDir($dirName);

        // When
        $service->unzip($zipFilePath, $dirName);

        // Then
        $this->assertTrue(file_exists($zipFilePath));
        $this->assertTrue(file_exists($dirName));
        $this->assertTrue(\is_dir($dirName));
        $this->assertTrue(file_exists($dirName . 'test') && is_dir($dirName . 'test'));

        // And
        // unpack it in test, scan target dir and compare file contents
        $zip = new \ZipArchive();
        $scanned_directory = array_diff(scandir($dirName . 'test'), ['..', '.']);

        if ($zip->open($zipFilePath) === true) {
            $this->assertEquals($zip->numFiles, count($scanned_directory));
            foreach ($scanned_directory as $file) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    if ($file === $zip->getNameIndex($i)) {
                        // contents of files from scanned dir and unzipped files should be the same
                        // it could be custom assertion - for better readability
                        $this->assertEquals(sha1_file($dirName.'/test/'.$file), sha1_file($dirName.'/test/'.$zip->getNameIndex($i)));
                    }
                }
            }
            $zip->close();
        }
    }
}
