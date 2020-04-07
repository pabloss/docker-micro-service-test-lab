<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Files\UploadedFileAdapter;
use App\Framework\Service\Files\UploadedFile;
use App\MixedContext\Domain\Application\DeployProcessApplication;
use App\MixedContext\Domain\Application\TestProcessApplication;
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
     * @Route("/test/{targetDir}", name="test")
     * @param string $targetDir
     * @param TestProcessApplication $application
     * @return RedirectResponseAlias|Response
     */
    public function test(string $targetDir, TestProcessApplication $application)
    {
        $application->run($this->getParameter('unpacked_directory').'/'.$targetDir);
        return new Response();
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
        $service->save(new UploadedFileAdapter($request->files->all()['files']), $this->getParameter('uploaded_directory'));

        return new Response();
    }

    /**
     * @Route("/deploy/{targetDir}", name="deploy")
     * @param string $targetDir
     * @param DeployProcessApplication $application
     * @return Response
     */
    public function deploy(string $targetDir, DeployProcessApplication $application)
    {
        $application->run($this->getParameter('unpacked_directory').'/'.$targetDir);
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


    /**
     * @param Request $request
     * @return bool
     */
    protected function isFileUploaded(Request $request): bool
    {
        return isset($request->files->all()[self::FILES]) && ($request->files->all()[self::FILES] instanceof BaseUploadedFile);
    }

    /**
     * @param array $filesBag
     * @return UploadedFile
     */
    protected function uploadedFile(array $filesBag): UploadedFile
    {
        return  UploadedFile::fromTargetDirAndBaseUploadedFile(
            $this->getParameter('uploaded_directory'),
            $filesBag[UploadedFile::FILES]
        );
    }
}
