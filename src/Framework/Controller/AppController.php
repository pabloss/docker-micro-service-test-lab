<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\File;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Entity\MicroService;
use App\Framework\Form\MicroServiceType;
use App\Framework\Service\Files\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    /**
     * @Route("/", name="app")
     * @param Request $request
     * @param Unpack $unpack
     * @param Dir $dir
     * @param File $file
     * @return RedirectResponseAlias|Response
     */
    public function index(Request $request, Unpack $unpack, Dir $dir, File $file)
    {
        $microService = new MicroService();
        $form = $this->createForm(MicroServiceType::class, $microService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Framework\Service\Files\UploadedFile $uploadedFile */
            $uploadedFile = new UploadedFile($this->getParameter('uploaded_directory'), $form['microService']->getData());

            if ($uploadedFile) {
                try {
                    $uploadedFile->move(
                        $this->getParameter('uploaded_directory'),
                        $uploadedFile->getUniqueFileName()
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    return new Response($e->getMessage(). "\n" . $e->getTraceAsString(), Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $microService->setMicroServicePackedFilename($uploadedFile->getUniqueFileName());
                if ($file->isMimeTypeOf(UploadedFile::ZIP_MIME_TYPE, $uploadedFile->getTargetFile())) {
                    $dir->sureTargetDirExists($unpack->getTargetDir($this->getParameter('unpacked_directory'), $uploadedFile->getTargetFile()));
                    $unpack->unzip($uploadedFile->getTargetFile(), $unpack->getTargetDir($this->getParameter('unpacked_directory'), $uploadedFile->getTargetFile()));
                }
            }
        }

        return $this->render('app/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
