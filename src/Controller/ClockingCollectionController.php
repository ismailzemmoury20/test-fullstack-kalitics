<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Form\CreateClockingType;
use App\Repository\ClockingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Clocking;
use App\Entity\ClockingItem;
use App\Form\CreateClockingByChief;

#[Route('/clockings')]
class ClockingCollectionController extends
    AbstractController
{

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/create', name: 'app_Clocking_create', methods: ['GET','POST',])]
    public function createClocking(
        EntityManagerInterface $entityManager,
        Request                $request
    ) : Response {
        $clocking = new Clocking();
        $form = $this->createForm(CreateClockingType::class, $clocking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $clocking = $form->getData();

            foreach($clocking->getClockingItems() as $clockingItem) {
                $clockingItem->setClocking($clocking);
                $entityManager->persist($clockingItem);
            }
            $entityManager->persist($clocking);
            $entityManager->flush();

            return $this->redirectToRoute('app_Clocking_list');
        }

        $formView = $form->createView();

        return $this->render('app/Clocking/create.html.twig', [
            'form' => $formView,
        ]);
    }

    #[Route('/create-by-chief', name: 'app_Clocking_create_by_chief', methods: ['GET', 'POST'])]
    public function createClockingByChief(EntityManagerInterface $entityManager,Request $request): Response 
    {
        $form = $this->createForm(CreateClockingByChief::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $users = $data['users'];
            $project = $data['project'];
            $date = $data['date'];
            $duration = $data['duration'];

            foreach ($users as $user) {
                $clocking = new Clocking();
                $clocking->setClockingUser($user);
                $clocking->setDate($date);

                $clockingItem = new ClockingItem();
                $clockingItem->setProject($project);
                $clockingItem->setDuration($duration);
                $clockingItem->setClocking($clocking);

                $entityManager->persist($clocking);
                $entityManager->persist($clockingItem);
            }

        $entityManager->flush();
        return $this->redirectToRoute('app_Clocking_list');
        }

        return $this->render('app/Clocking/create_by_chief.html.twig', [
        'form' => $form->createView(),
        ]);
    }
    /**
     * @param \App\Repository\ClockingRepository $clockingRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/', name: 'app_Clocking_list', methods: ['GET'])]
    public function listClockings(ClockingRepository $clockingRepository) : Response
    {
        $clockings = $clockingRepository->findAll();

        return $this->render('app/Clocking/list.html.twig', [
            'clockings' => $clockings,
        ]);
    }
}
