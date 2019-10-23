<?php
declare(strict_types=1);

/**
 * Class UploadCest
 */
class UploadCest
{
    const TEST_UPLOADED_DIR = "tests/_data/";

    public function _after(\AcceptanceTester $I)
    {
        file_put_contents($this->getUploadedDirName().".gitkeep", "");
    }

    // tests
    /**
     * @param FunctionalTester $I
     */
    public function tryToUpload(FunctionalTester $I)
    {
        $I->cleanDir($this->getUploadedDirName());
        $I->amOnPage("/");
        $I->seeFileFound("test.upload", self::TEST_UPLOADED_DIR);
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
        return scandir(self::TEST_UPLOADED_DIR . "uploaded/", SCANDIR_SORT_DESCENDING)[0];
    }

    /**
     * @return string
     */
    private function getUploadedDirName(): string
    {
        return self::TEST_UPLOADED_DIR . "uploaded/";
    }
}
