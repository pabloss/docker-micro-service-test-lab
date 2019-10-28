<?php
declare(strict_types=1);

/**
 * Class UploadCest
 */
class UploadCest
{
    const TEST_UPLOADED_DIR = "files/";

    public function _after(\AcceptanceTester $I)
    {
        $I->dir(self::TEST_UPLOADED_DIR . 'unpacked/');
        $I->dir(self::TEST_UPLOADED_DIR . 'uploaded/');
    }

    // tests

    /**
     * @param FunctionalTester $I
     */
    public function tryToUpload(FunctionalTester $I)
    {
        $I->cleanDir($this->getUploadedDirName());
        $I->amOnPage("/");
        $I->seeFileFound("test.upload", "tests/_data/");
        $I->attachFile("micro_service[microService]", "test.upload");
        $I->click("Submit");
        $I->assertStringStartsWith("test", $this->getLastFileName());
        $I->assertRegExp("/upload$/", $this->getLastFileName());
    }


    /**
     * @return mixed
     */
    private function getLastFileName()
    {
        return array_diff(scandir("tests/_data/"."uploaded/", SCANDIR_SORT_DESCENDING),  ['..', '.'])[0];
    }

    /**
     * @return string
     */
    private function getUploadedDirName(): string
    {
        return self::TEST_UPLOADED_DIR . "uploaded/";
    }
}
