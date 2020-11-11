<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\Framework\Application\Get\GetMicroServiceApplication;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiAppController
{
    /**
     * @Route("/api/get-grid-content", name="api_get_grid_content")
     * @param GetMicroServiceApplication $application
     *
     * @return JsonResponse
     */
    public function getGridContent(GetMicroServiceApplication  $application)
    {
        return new JsonResponse($application->getAllAsArray());
    }

    /**
     * @Route("/api/test-definition/{uuid}", name="api_get_test_definiion")
     *
     * @param UService $UService
     *
     * @return Response
     */
    public function apiGetMicroService(UService $UService)
    {
        return new JsonResponse(
            \array_merge(
                Test::asArray($UService->getTests()->last()),
                [
                    'created' => $UService->getCreated()->format('Y-m-d H:i:s'),
                ]
            )
        );
    }
}
