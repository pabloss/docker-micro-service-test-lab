<?php namespace Integration;

use App\AppCore\Domain\Service\Command\CommandProcessor;

class DeployCommandTest extends \Codeception\Test\Unit
{
    const TEST_UPLOADED_DIR = __DIR__ . "/../../../tests/_data/";
    const TEST_DOCKER_IMAGE = 'bulletinboard:1.0';
    const DESCRIPTOR_SPEC = [
        0 => ["pipe", "r"],   // stdin is a pipe that the child will read from
        1 => ["pipe", "w"],   // stdout is a pipe that the child will write to
        2 => ["pipe", "w"]    // stderr is a pipe that the child will write to
    ];

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        $this->tester->docker();
        $this->tester->dir(self::TEST_UPLOADED_DIR . 'uploaded/');
        $this->tester->dir(self::TEST_UPLOADED_DIR . 'unpacked/');
    }

    public function testSomeRunBuild()
    {
        \exec("bin/console deploy", $output, $returnVal);
        $this->tester->assertGreaterThan(0, $returnVal);
        $this->tester->assertNotNull($output);

        flush();
        $process = proc_open(
            " docker-compose -f " .
            self::TEST_UPLOADED_DIR .
            "/micro-service-1/docker-compose.yml".
            " up -d --force-recreate" .
            " 2>&1",
            CommandProcessor::DESCRIPTOR_SPECS,
            $pipes,
            realpath('./'),
            []
        );
        if (is_resource($process)) {
            $i = 0;
            while (($s = fgets($pipes[1]))) {
                if (empty(\trim($s))) {
                    continue;
                }
                $this->tester->assertIsString($s);
                $this->tester->assertNotEmpty($s);
                $this->tester->assertStringNotContainsString("does not exist", $s);
                $this->tester->assertStringNotContainsString("missing", $s);
                $this->tester->assertStringNotContainsString("requires at least", $s);

                flush();
                $i++;
            }
            if (0 === $i) {
                $this->tester->fail("0 spins of loop");
            }
        }
    }
}
