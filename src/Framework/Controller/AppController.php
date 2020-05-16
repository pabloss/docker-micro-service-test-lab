<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\DeployApplication;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Files\UploadedFileAdapter;
use App\Framework\Persistence\PersistGatewayAdapter;
use App\Framework\Service\Files\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile as BaseUploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppController
 * @package App\Framework\Controller
 */
class AppController extends AbstractController
{
    const FILES = 'files';

    /**
     * @Route("/", name="app")
     * @return RedirectResponseAlias|Response
     */
    public function index()
    {
        return $this->render('app/index.html.twig');
    }

    /**
     * @Route("/upload", name="photos.upload")
     * @param Request                  $request
     * @param FrameworkSaveApplication $service
     *
     * @return Response
     */
    public function upload(Request $request, FrameworkSaveApplication $service)
    {
        $uniqid = \uniqid();
        $newDirPath = $this->getParameter('uploaded_directory') . '/' . $uniqid;
        \mkdir($newDirPath);

        $service->save(new UploadedFileAdapter($request->files->all()['files']), $newDirPath);
        return new Response($uniqid);
    }

    /**
     * @Route("/deploy", name="deploy")
     * @param Request               $request
     * @param DeployApplication     $application
     * @param PersistGatewayAdapter $adapter
     *
     * @return Response
     */
    public function deploy(Request $request, DeployApplication $application, PersistGatewayAdapter $adapter)
    {
        $uniqid = $request->getContent();
        $targetDir = $this->getParameter('unpacked_directory') . '/' . $uniqid;
        $application->deploy((string)($adapter->nextId() - 1), $targetDir, 'image_prefix','container_prefix');
        return new Response();
    }

    /**
     * @Route("/c3/report/{suffix}", name="c3")
     * @return Response
     */
    public function c3(string  $suffix)
    {
        return new Response();
    }
}
