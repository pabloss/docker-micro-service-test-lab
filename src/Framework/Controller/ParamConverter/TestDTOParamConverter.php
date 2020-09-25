<?php
declare(strict_types=1);

namespace App\Framework\Controller\ParamConverter;

use App\AppCore\Domain\Actors\TestDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class TestDTOParamConverter implements ParamConverterInterface
{
    const NAME = 'testDTO';
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $data = \json_decode($request->getContent(), true);
        $request->attributes->set(self::NAME, new TestDTO($data['uuid'], $data['requested_body'], $data['body'], $data['header'], $data['url'], $data['script']));
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return true;
    }
}
