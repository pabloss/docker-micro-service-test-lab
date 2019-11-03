<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\File;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Entity\MicroService;
use App\Framework\Form\MicroServiceType;
use App\Framework\Service\Files\Params;
use App\Framework\Service\Files\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile as BaseUploadedFile;

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
        return $this->render('app/index.html.twig', [
            'form' => $this->createForm(MicroServiceType::class, new MicroService())->createView(),
        ]);
    }

    /**
     * @Route("/test", name="test")
     * @return RedirectResponseAlias|Response
     */
    public function test()
    {
        return new JsonResponse("test");
    }

    /**
     * @Route("/upload", name="photos.upload")
     * @param Request $request
     * @param Unpack $unpack
     * @param Dir $dir
     * @param File $file
     * @return RedirectResponseAlias|Response
     */
    public function upload(Request $request, Unpack $unpack, Dir $dir, File $file)
    {
        if($this->isFileUploaded($request)){
            return $this->json([]);
        }

        if ($this->uploadedFile($request)) {
            try {
                $this->uploadedFile($request)->move(
                    $this->getParameter('uploaded_directory'),
                    $this->uploadedFile($request)->getUniqueFileName()
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return new JsonResponse([$e->getMessage(). "\n" . $e->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $microService = new MicroService();
            $microService->setMicroServicePackedFilename($this->uploadedFile($request)->getUniqueFileName());
            if ($file->isMimeTypeOf(UploadedFile::ZIP_MIME_TYPE, $this->uploadedFile($request)->getTargetFile())) {
                $dir->sureTargetDirExists($unpack->getTargetDir($this->getParameter('unpacked_directory'), $this->uploadedFile($request)->getTargetFile()));
                $unpack->unzip($this->uploadedFile($request)->getTargetFile(), $unpack->getTargetDir($this->getParameter('unpacked_directory'), $this->uploadedFile($request)->getTargetFile()));
            }
        }

        return $this->redirectToRoute("app");
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isFileUploaded(Request $request): bool
    {
        return !isset($request->files->all()[self::FILES]) || !($request->files->all()[self::FILES] instanceof BaseUploadedFile);
    }

    /**
     * @param Request $request
     */
    protected function createParams(Request $request): void
    {
        Params::createInstance($this->getParameter('uploaded_directory'), $request->files->all()[self::FILES]);
    }

    /**
     * @param Request $request
     * @return UploadedFile
     */
    protected function uploadedFile(Request $request): UploadedFile
    {
        $this->createParams($request);
        return UploadedFile::instance(Params::getInstance());
    }
}
