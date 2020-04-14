<?php

use App\AppCore\Application\DeployApplication;
use App\AppCore\Domain\Actors\uServiceInterface;
use App\AppCore\Domain\DomainDeployApplication;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\UnpackServiceInterface;

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
        $unpackService->unpack($uService->reveal(), $unpackedDir .$id)->will(function ($args) use ($uService, $unpackedDir, $id){
            $uService->unpacked()->willReturn($args[1]);
            return $uService->reveal();
        });

        $repo = $this->prophesize(uServiceRepository::class);
        $repo->find($id)->shouldBeCalled()->willReturn($uService->reveal());
        $repo->persist($uService->reveal())->shouldBeCalled();
        $service = new DeployApplication($unpackService->reveal(), $repo->reveal());

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

        $repo->persist($uService->reveal());
        $service->deploy($id, $unpackedDir.$id);

        $this->tester->assertEquals($unpackedDir .$id, $repo->reveal()->find($id)->unpacked());
    }
}
