<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MaterielType;
use App\Services\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MaterielController extends AbstractController
{
    /**
     * Récupérer tous les matériels dont la quantité est > 0
     *
     * @param MaterielRepository $materielRepository
     * @return Response
     */
    #[Route('/materiel', name: 'app_materiel')]
    public function index(MaterielRepository $materielRepository): Response
    {
        // Récupérer tous les matériels dont la quantité est > 0
        $materiels = $materielRepository->findByQty();

        return $this->render('materiel/index.html.twig', [
            'materiels' => $materiels,
        ]);
    }

    /**
     * Affichage des données d'un matériel par son id
     */
    #[Route('/materiel/detail/{id}', name: 'detail_materiel')]
    public function detail($id, MaterielRepository $materielRepository): Response
    {    
        $materiel = $materielRepository->findById($id);
        return $this->render('materiel/detail.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    /**
     * Modifier un matériel
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     */
    #[Route('/materiel/{id}/edit', name: 'edit_materiel')]
    public function edit(Request $request, Materiel $materiel, EntityManagerInterface $entityManager) : Response
    {
        // Créer le formulaire pour modifier le matériel
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        // Sauvegarder les modifications si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les modifications dans la base de données
            $entityManager->flush();

            // Redirection vers la liste des matériels
            return $this->redirectToRoute('app_materiel');
        }

        // Afficher le formulaire pour modifier le matériel
        return $this->render('materiel/edit.html.twig', [
           'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Décrémenter la quantité d'un matériel
     *
     * @param Materiel $materiel
     * @param EntityManagerInterface $entityManager
    */
    #[Route('/materiel/decrement/{id}', name: 'materiel_decrement')]
    public function decrement(Materiel $materiel, MaterielRepository $materielRepository) : Response
    {
        // Décrémenter la quantité du matériel
        $materielRepository->decrementQty($materiel);

        // Redirection vers la page d'accueil
        return $this->redirectToRoute('app_materiel');
    }

    /**
     * Afficher un PDF des données d'un matériel
     *
     * @param Materiel $materiel
     * @param PdfService $pdfService
    */
    #[Route('/materiel/pdf/{id}', name: 'generate_pdf')]
    public function generatePdf(Materiel $materiel, PdfService $pdfService)
    {
        // Générer le contenu HTML à partir du template
        $htmlContent = $this->render('materiel/detail.html.twig', ['materiel' => $materiel]);

        // Afficher le PDF dans le navigateur
        $pdfService->showPdfFile($htmlContent);
    }
                               
}
