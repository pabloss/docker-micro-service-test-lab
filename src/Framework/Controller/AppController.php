<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Domain\Application\DeployProcessApplication;
use App\AppCore\Domain\Application\TestProcessApplication;
use App\Framework\Entity\MicroService;
use App\Framework\Event\FileUploadedEvent;
use App\Framework\Service\Files\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile as BaseUploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param Request $request
     * @param EventDispatcherInterface $dispatcher
     * @return RedirectResponseAlias|Response
     */
    public function upload(Request $request, EventDispatcherInterface $dispatcher)
    {

        if(false === $this->isFileUploaded($request)){
            return $this->json([]);
        }

        if ($this->uploadedFile($request->files->all())) {
            try {
                $this->uploadedFile($request->files->all())
                    ->move(
                        $this->getParameter('uploaded_directory'),
                        $this->uploadedFile($request->files->all())->getUniqueFileName()
                    );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return new JsonResponse([$e->getMessage(). "\n" . $e->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $microService = new MicroService();
            $microService->setMicroServicePackedFilename($this->uploadedFile($request->files->all())->getUniqueFileName());

            $event = new FileUploadedEvent($request->files->all());
            $dispatcher->dispatch($event, FileUploadedEvent::NAME);
        }

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
