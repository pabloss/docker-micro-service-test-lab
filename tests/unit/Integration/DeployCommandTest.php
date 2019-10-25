<?php namespace Integration;

class DeployCommandTest extends \Codeception\Test\Unit
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
    public function testSomeFeature()
    {
        \exec("bin/console deploy", $output, $returnVal);
        $this->tester->assertSame(1, $returnVal);
        $this->tester->assertNotNull($output);
        $dockerContainer = "docker ps -a | grep hello-world | awk '{print $1}'";
        \exec("docker stop $($dockerContainer)");
        \exec("docker rm $($dockerContainer)");
        \exec("docker rmi hello-world:latest");
        $expectedOutput = <<<HERE
Hello from Docker!
This message shows that your installation appears to be working correctly.
To generate this message, Docker took the following steps:
 1. The Docker client contacted the Docker daemon.
 2. The Docker daemon pulled the "hello-world" image from the Docker Hub.
    (amd64)
 3. The Docker daemon created a new container from that image which runs the
    executable that produces the output you are currently reading.
 4. The Docker daemon streamed that output to the Docker client, which sent it
    to your terminal.
To try something more ambitious, you can run an Ubuntu container with:
 $ docker run -it ubuntu bash
Share images, automate workflows, and more with a free Docker ID:
 https://hub.docker.com/
For more examples and ideas, visit:
 https://docs.docker.com/get-started/
HERE;

        $expecredOutputLines = [
            "Unable to find image 'hello-world:latest' locally",
            "latest: Pulling from library/hello-world",
            "Pulling fs layer",
            "Verifying Checksum",
            "Download complete",
            "Pull complete",
            "Digest:",
            "Status: Downloaded newer image for hello-world:latest",
        ];
        $message = \explode("\n", $expectedOutput);

        $expecredOutputLines = \array_merge($expecredOutputLines, $message);
        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );
        flush();
        $process = proc_open("bin/console deploy hello-world 2>&1", $descriptorspec, $pipes, realpath('./'), array());
        if (is_resource($process)) {
            $i = 0;
            while (($s = fgets($pipes[1]))) {
                if(empty(\trim($s))){
                    continue;
                }
                $this->tester->assertStringContainsString($expecredOutputLines[$i], $s) ;
                flush();
                $i++;
            }
            if(0 === $i){
                $this->tester->fail("0 spins of loop");
            }
        }
    }
}
