<?php

namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\uServiceInterface;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\Build\BuildServiceInterface;
use App\AppCore\Domain\Service\Build\Unpack\UnpackServiceInterface;
use App\AppCore\Domain\Service\Command\BuildCommand;
use App\AppCore\Domain\Service\Command\CommandFactoryInterface;
use App\AppCore\Domain\Service\Command\CommandsCollectionInterface;
use App\AppCore\Domain\Service\Command\RunCommand;
use App\Framework\Files\Dir;

class DomainDeployApplicationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testSomeFeature()
    {

        $id = 'id';
        $unpackedDir = 'unpacked';

        $uService = $this->prophesize(uServiceInterface::class);
        $unpackService = $this->prophesize(UnpackServiceInterface::class);
        $unpackService->unpack($uService->reveal(), $unpackedDir . $id)->will(function ($args) use (
            $uService
        ) {
            $uService->unpacked()->willReturn($args[1]);
            return $uService->reveal();
        });

        $repo = $this->prophesize(uServiceRepositoryInterface::class);
        $repo->find($id)->shouldBeCalled()->willReturn($uService->reveal());
        $repo->persist($uService->reveal(), $id)->shouldBeCalled();

        $buildService = $this->prophesize(BuildServiceInterface::class);
        $dir = $this->prophesize(Dir::class);
        $dir->findFile($unpackedDir.$id, 'Dockerfile')->willReturn('Dockerfile');


        $buildCommand = $this->prophesize(BuildCommand::class);
        $runCommand = $this->prophesize(RunCommand::class);
        $collection = $this->prophesize(CommandsCollectionInterface::class);
        $collection->getCommand(0)->willReturn($buildCommand->reveal());
        $collection->getCommand(1)->willReturn($runCommand->reveal());
        $commandFactory = $this->prophesize(CommandFactoryInterface::class);

        $commandFactory->createCommand('build', 'Dockerfile', 'imagePref_id')->willReturn($buildCommand->reveal());
        $commandFactory->createCommand('run', 'containerPref_id', 'imagePref_id')->willReturn($runCommand->reveal());
        $commandFactory->createCollection([$buildCommand->reveal(), $runCommand->reveal()])->willReturn($collection->reveal());

        $service = new DeployApplication($unpackService->reveal(), $buildService->reveal(), $dir->reveal(), $commandFactory->reveal(), $repo->reveal());

        /**
         * @todo
         *      - weż plik z jakiejś lokalizacji
         *      - rozpakuj do innej
         *      - wyraź to przez domenę
         *          -- weź encję z repo
         *          -- pobierz jej file path
         *      - na uService robimy deploy(): `deploy($id)`
         *      - stosując zależność UnpackServiceInterface oraz Repo: rozpakuj (do nowej lokalizcji) i zapisz do bazy
         */

        $repo->reveal()->persist($uService->reveal(), $id);
        $service->deploy($id, $unpackedDir . $id, 'imagePref', 'containerPref');

        $this->tester->assertEquals($unpackedDir . $id, $repo->reveal()->find($id)->unpacked());
    }
}
