<?php

namespace App\Controller;

use App\DataFixtures\PersonneFixture;
use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[route('/', name: 'personne_list')]
    public function index(ManagerRegistry $doctrine): Response
   {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();

        return $this->render("personne/index.html.twig", [
            'personne' => $personnes
        ]);

    }

    #[route('/{id<\d+>}', name: 'personne_detail')]
    public function detail(ManagerRegistry $doctrine, $id): Response
   {
        $repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);

        if(!$personne) {
            $this->addFlash('error', 'La personne avec l\'id $id  n\'existe pas ');
            return $this->redirectToRoute('personne_list');
        }
        return $this->render("personne/detail.html.twig", [
            'personne' => $personne
        ]);

    }
    
    #[Route('/add', name: 'app_personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstName("NISHIMWE");
        $personne->setLastName("Dany chaste");
        $personne->setAge(21);
        //ajout de l'operation d'insertion de la personne dans la transaction
        $entityManager->persist($personne);
        //Exécution de la transaction
        $entityManager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne
        ]);
    }
}
