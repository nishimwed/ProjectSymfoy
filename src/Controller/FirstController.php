<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/one', name: 'app_first')]
    public function index(): Response
    {
       
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
            'nom' => 'NISHIMWE',
            'prenom' => 'Dany Chaste',
            'path' => ' '
        ]);
    }

    #[Route('/sayName/{firstName}/{lastName}', name: 'nm')]
    public function test($firstName,$lastName): Response
    {
       /* $rdn = rand(0,10);
        echo "$rdn";
        if ($rdn % 2 == 0){
            return $this->redirectToRoute('app_first');
        }

        //return $this->forward('App\Controller\FirstController::index');*/
        return $this->render('first/hello.html.twig',[
            'nom' => $firstName,
            'prenom' => $lastName,
            
        ]);

    }
}
