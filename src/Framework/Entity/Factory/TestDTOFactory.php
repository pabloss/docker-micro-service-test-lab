<?php
declare(strict_types=1);

namespace App\Framework\Entity\Factory;

use App\AppCore\Domain\Actors\Factory\TestDTOFactoryInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestEntityInterface;

/**
 * Class TestDTOFactory
 *
 * @package App\Framework\Entity\Factory
 */
class TestDTOFactory implements TestDTOFactoryInterface
{
    /**
     * @param TestEntityInterface $testEntity
     * @param string              $requestContent
     *
     * @return TestDTO
     */
    public function create(TestEntityInterface $testEntity, string $requestContent): TestDTO
    {
        return new TestDTO(
            $testEntity->getUuid(),
            $testEntity->getRequestedBody(),
            $requestContent,
            $testEntity->getHeader(),
            $testEntity->getUrl(),
            $testEntity->getScript()
        );
    }
}
