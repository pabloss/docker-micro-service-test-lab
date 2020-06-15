<?php

use App\MixedContext\Domain\Service\Command\CommandProcessor;


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
     * @Given I have uploaded
     */
    public function iHaveUploaded()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I have uploaded` is not defined");
    }

    /**
     * @Given I have deployed micro service
     */
    public function iHaveDeployedMicroService()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I have deployed micro service` is not defined");
    }

    /**
     * @Given I have micro service with some uuid
     */
    public function iHaveMicroServiceWithSomeUuid()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I have micro service with some uuid` is not defined");
    }

    /**
     * @Given I have a form to define request by target url and body
     */
    public function iHaveAFormToDefineRequestByTargetUrlAndBody()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I have a form to define request by target url and body` is not defined");
    }

    /**
     * @When I run test
     */
    public function iRunTest()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I run test` is not defined");
    }

    /**
     * @Then I should take request from last micro service
     */
    public function iShouldTakeRequestFromLastMicroService()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I should take request from last micro service` is not defined");
    }

    /**
     * @Then I should match requested body with received request body
     */
    public function iShouldMatchRequestedBodyWithReceivedRequestBody()
    {
        throw new \PHPUnit\Framework\IncompleteTestError("Step `I should match requested body with received request body` is not defined");
    }

}
