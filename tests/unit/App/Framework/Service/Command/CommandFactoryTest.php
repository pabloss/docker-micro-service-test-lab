<?php namespace App\Framework\Service\Command;

use App\AppCore\Domain\Service\CommandFactoryInterface;

class CommandFactoryTest extends \Codeception\Test\Unit
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
        $factory = new CommandFactory();

        $buildCommand = new BuildCommand('Dockerfile', 'imagePref');
        $runCommand = new RunCommand('containerPref', 'imagePref');

        $this->tester->assertEquals(
            $buildCommand,
            $factory->createCommand('build', 'Dockerfile', 'imagePref')
        );

        $this->tester->assertEquals(
            $runCommand,
            $factory->createCommand('run', 'containerPref', 'imagePref')
        );

        $commandCollection = new CommandCollection();
        $commandCollection->addCommand($buildCommand);
        $commandCollection->addCommand($runCommand);
        $this->tester->assertEquals(
            $commandCollection,
            $factory->createCollection([$buildCommand, $runCommand])
        );

        $this->tester->assertInstanceOf(CommandFactoryInterface::class, $factory);

    }
}
