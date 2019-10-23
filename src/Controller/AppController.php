<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\MicroService;
use App\Form\MicroServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Files\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class AppController
 * @package App\Controller
 */
class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     * @param Request $request
     * @return RedirectResponseAlias|Response
     */
    public function index(Request $request)
    {
        $microService = new MicroService();
        $form = $this->createForm(MicroServiceType::class, $microService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = new UploadedFile($form['microService']->getData());

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
            }
        }

        return $this->render('app/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
