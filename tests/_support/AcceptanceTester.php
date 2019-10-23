<<?php


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

    /**
     * @Given I have :arg1 path
     * @param $arg1
     */
    public function iHavePath($arg1)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I have :arg1 path` is not defined");
    }

    /**
     * @When I unpack it to :arg1 path
     * @param $arg1
     */
    public function iUnpackItToPath($arg1)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I unpack it to :arg1 path` is not defined");
    }

    /**
     * @Then :arg1 dir is created
     * @param $arg1
     */
    public function dirIsCreated($arg1)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `:arg1 dir is created` is not defined");
    }

    /**
     * @Then content of unzipped :arg1 and :arg2 are the same
     * @param $arg1
     * @param $arg2
     */
    public function contentOfUnzippedAndAreTheSame($arg1, $arg2)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `content of unzipped :arg1 and :arg2 are the same` is not defined");
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
