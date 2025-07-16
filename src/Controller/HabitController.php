<?php

namespace App\Controller;

use App\Entity\Habit;
use App\Form\HabitType;
use App\Repository\HabitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/habit')]
final class HabitController extends AbstractController
{
    #[Route(name: 'app_habit_index', methods: ['GET'])]
    public function index(HabitRepository $habitRepository): Response
    {
        return $this->render('habit/index.html.twig', [
            'habits' => $habitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_habit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $habit = new Habit();
        $form = $this->createForm(HabitType::class, $habit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de la date sélectionnée dans le formulaire
            $dateInput = $form->get('singleDate')->getData();

            if ($dateInput instanceof \DateTimeInterface) {
                $existingDates = $habit->getDate() ?? [];
                $existingDates[] = $dateInput->format('Y-m-d');
                $habit->setDate($existingDates);
            }

            $entityManager->persist($habit);
            $entityManager->flush();

            return $this->redirectToRoute('app_habit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('habit/new.html.twig', [
            'habit' => $habit,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_habit_show', methods: ['GET'])]
    public function show(Habit $habit): Response
    {
        return $this->render('habit/show.html.twig', [
            'habit' => $habit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_habit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habit $habit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HabitType::class, $habit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de la date sélectionnée dans le formulaire
            $dateInput = $form->get('singleDate')->getData();

            if ($dateInput instanceof \DateTimeInterface) {
                $existingDates = $habit->getDate() ?? [];
                $existingDates[] = $dateInput->format('Y-m-d');
                $habit->setDate($existingDates);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_habit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('habit/edit.html.twig', [
            'habit' => $habit,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_habit_delete', methods: ['POST'])]
    public function delete(Request $request, Habit $habit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$habit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($habit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_habit_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/progress', name: 'app_habit_progress', methods: ['GET'])]
    public function progress(Habit $habit): Response
    {
        return $this->render('habit/progress.html.twig', [
            'habit' => $habit,
        ]);
    }
}
