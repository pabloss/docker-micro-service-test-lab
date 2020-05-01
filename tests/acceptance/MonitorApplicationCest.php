<?php

class MonitorApplicationCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $testText = "TEST IT!";
        $testCommand = "echo $testText";
        $I->runShellCommand($testCommand, false);
        \Ratchet\Client\connect('ws://service-test-lab-new.local:4444')->then(function($conn) use (&$response) {
            $conn->on('message', function($msg) use ($conn, &$response) {
                $response = $msg;
                $conn->close();
            });

            $conn->send('Hello World!');
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });

        $I->assertEquals($testText, $response);
    }
}
