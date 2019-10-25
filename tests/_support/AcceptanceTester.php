<<?php

use App\Files\Unpack;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    const TEST_UPLOADED_DIR = "files/";
    use _generated\AcceptanceTesterActions;

    /** @var string */
    private $filePath;

    /**
     * @Given I have :filename path
     * @param $filename
     */
    public function iHavePath($filename)
    {
        Codeception\PHPUnit\TestCase::assertFileExists(__DIR__. '/../_data/' . $filename);
        $this->filePath = __DIR__. '/../_data/' . $filename;
    }

    /**
     * @When I unpack it to :toDirPath path
     * @param $toDirPath
     */
    public function iUnpackItToPath($toDirPath)
    {
        $this->cleanDir(__DIR__. '/../_data/unpacked/');

        $service = new Unpack();
        $service->unzip($this->filePath, __DIR__. '/../_data/'.$toDirPath);
    }

    /**
     * @Then :dirName dir is created
     * @param $dirName
     */
    public function dirIsCreated($dirName)
    {
        $this->assertTrue(file_exists(__DIR__. '/../_data/' . $dirName));
        $this->assertTrue(is_dir(__DIR__. '/../_data/' . $dirName));
    }

    /**
     * @Then content of unzipped :zipFilePath and :unzippedFilePath are the same
     * @param $zipFilePath
     * @param $unzippedFilePath
     */
    public function contentOfUnzippedAndAreTheSame($zipFilePath, $unzippedFilePath)
    {
        // unpack it in test, scan target dir and compare file contents
        $zip = new ZipArchive();
        $scanned_directory= array_diff(scandir(__DIR__. '/../_data/'.$unzippedFilePath), ['..', '.']);

        if ($zip->open(__DIR__. '/../_data/'.$zipFilePath) === true) {
            $this->assertEquals($zip->numFiles, count($scanned_directory));
            foreach ($scanned_directory as $file) {
                for($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if($file === $filename){
                        $this->assertEquals(sha1_file(__DIR__. '/../_data/unpacked/test/'.$file), sha1_file(__DIR__. '/../_data/unpacked/test/'.$filename));
                    }
                }
            }
            $zip->close();
        }
    }

    /**
     * @Given I have :filename file
     * @param $filename
     */
    public function iHaveFile($filename)
    {
        Codeception\PHPUnit\TestCase::assertFileExists(__DIR__. '/../_data/' . $filename);
    }

    /**
     * @When I upload :filename file
     * @param $filename
     */
    public function iUploadFile($filename)
    {
        $this->amOnPage("/");
        $this->attachFile("micro_service[microService]", $filename);
        $this->click('Submit');
    }

    /**
     * @Then I can find file that name starts with :prefix in :uploadDir location
     * @param $prefix
     * @param $uploadDir
     */
    public function iCanFindFileThatNameStartsWithInLocation($prefix, $uploadDir)
    {
        Codeception\PHPUnit\TestCase::assertStringStartsWith($prefix, $this->getLastFileName($uploadDir));
    }

    /**
     * @param string $subDir
     * @return mixed
     */
    private function getLastFileName(string $subDir)
    {
        return scandir(self::TEST_UPLOADED_DIR . $subDir, SCANDIR_SORT_DESCENDING)[0];
    }
}
