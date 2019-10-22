<?php


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
    use _generated\AcceptanceTesterActions;

    /**
     * @Given I have :arg1 path
     */
    public function iHavePath($arg1)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I have :arg1 path` is not defined");
    }

    /**
     * @When I unpack it to :arg1 path
     */
    public function iUnpackItToPath($arg1)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I unpack it to :arg1 path` is not defined");
    }

    /**
     * @Then :arg1 dir is created
     */
    public function dirIsCreated($arg1)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `:arg1 dir is created` is not defined");
    }

    /**
     * @Then content of unzipped :arg1 and :arg2 are the same
     */
    public function contentOfUnzippedAndAreTheSame($arg1, $arg2)
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `content of unzipped :arg1 and :arg2 are the same` is not defined");
    }

    /**
     * @Given I have :arg1 file
     */
    public function iHaveFile($arg1)
    {
        Codeception\PHPUnit\TestCase::assertFileExists(__DIR__. '/../_data/' . $arg1);
    }

    /**
     * @When I upload :arg1 file to :arg2 location
     */
    public function iUploadFileToLocation($arg1, $arg2)
    {
        $this->amOnPage("/");
        $this->attachFile('input[@type="file"]', $arg1);
        $this->click('Submit');
    }

    /**
     * @Then I can find :arg1 file in :arg2 location
     */
    public function iCanFindFileInLocation($arg1, $arg2)
    {
        Codeception\PHPUnit\TestCase::assertFileExists($arg2 . "/". $arg1);
    }

}
