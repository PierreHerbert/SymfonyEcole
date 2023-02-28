<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\ElevesType;
use App\Repository\ElevesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/eleves')]
class ElevesController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_eleves_index', methods: ['GET'])]
    public function index(ElevesRepository $elevesRepository): Response
    {
        return $this->render('eleves/index.html.twig', [
            'eleves' => $elevesRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_eleves_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ElevesRepository $elevesRepository): Response
    {
        $elefe = new Eleves();
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elevesRepository->save($elefe, true);

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleves/new.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_eleves_show', methods: ['GET'])]
    public function show(Eleves $elefe): Response
    {
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_eleves_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eleves $elefe, ElevesRepository $elevesRepository): Response
    {
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elevesRepository->save($elefe, true);

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_eleves_delete', methods: ['POST'])]
    public function delete(Request $request, Eleves $elefe, ElevesRepository $elevesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$elefe->getId(), $request->request->get('_token'))) {
            $elevesRepository->remove($elefe, true);
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
