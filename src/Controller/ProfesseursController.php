<?php

namespace App\Controller;

use App\Entity\Professeurs;
use App\Form\ProfesseursType;
use App\Repository\ProfesseursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/professeurs')]
class ProfesseursController extends AbstractController
{

    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_professeurs_index', methods: ['GET'])]
    public function index(ProfesseursRepository $professeursRepository): Response
    {
        return $this->render('professeurs/index.html.twig', [
            'professeurs' => $professeursRepository->findAll(),
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_professeurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProfesseursRepository $professeursRepository): Response
    {
        $professeur = new Professeurs();
        $form = $this->createForm(ProfesseursType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professeursRepository->save($professeur, true);

            return $this->redirectToRoute('app_professeurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('professeurs/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_professeurs_show', methods: ['GET'])]
    public function show(Professeurs $professeur): Response
    {
        return $this->render('professeurs/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_professeurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeurs $professeur, ProfesseursRepository $professeursRepository): Response
    {
        $form = $this->createForm(ProfesseursType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professeursRepository->save($professeur, true);

            return $this->redirectToRoute('app_professeurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('professeurs/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_professeurs_delete', methods: ['POST'])]
    public function delete(Request $request, Professeurs $professeur, ProfesseursRepository $professeursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
            $professeursRepository->remove($professeur, true);
        }

        return $this->redirectToRoute('app_professeurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
