<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todos')){
            $todos = [
                'achat'=>'acheter clé usb',
                'cours'=>'finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos',$todos);
            $this->addFlash("info", "la liste des todos est initialisée avec succès ");
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route("/todo/add/{nom}/{content}",name:'add_todo')]
    public function addTodo(Request $request, $nom, $content): RedirectResponse{
        //verification de l'existance d'un tableau todo et de l'initialisation des nouveaux éléments 
        $session = $request->getSession();
        if($session->has('todos')){
            //verification s'il existe déjà un objet que je voulais ajouter 
            $todos = $session->get('todos');
            if(isset($todos[$nom])){
                $this->addFlash('error', 'le todo  exista déjà');
            }
            else{
                $todos[$nom] = $content;
                $this->addFlash('success', 'Le todo est ajouté avec succès!');
                $session->set('todos', $todos);
            }
        }else{
            $this->addFlash('error',"La liste des todos n'est pas encore initialisée ");
        }

        return $this->redirectToRoute('app_todo');

    }

    #[Route("/todo/update/{nom}/{content}",name:'update_todo')]
    public function updateTodo(Request $request, $nom, $content): RedirectResponse{
        //verification de l'existance d'un tableau todo et de l'initialisation des nouveaux éléments 
        $session = $request->getSession();
        if($session->has('todos')){
            //verification s'il existe déjà un objet que je voulais ajouter 
            $todos = $session->get('todos');
            if(!isset($todos[$nom])){
                $this->addFlash('error', 'le todo $nom  n"existe pas ');
            }
            else{
                $todos[$nom] = $content;
                $this->addFlash('success', 'Le todo est modifié avec succès!');
                $session->set('todos', $todos);
            }
        }else{
            $this->addFlash('error',"La liste des todos n'est pas encore initialisée ");
        }

        return $this->redirectToRoute('app_todo');

    }
    #[Route("/todo/delete/{nom}",name:'delete_todo')]
    public function deleteTodo(Request $request, $nom): RedirectResponse{
        //verification de l'existance d'un tableau todo et de l'initialisation des nouveaux éléments 
        $session = $request->getSession();
        if($session->has('todos')){
            //verification s'il existe déjà un objet que je voulais ajouter 
            $todos = $session->get('todos');
            if(!isset($todos[$nom])){
                $this->addFlash('error', 'le todo $nom n"existe pas');
            }
            else{
                unset($todos[$nom]);
                $this->addFlash('success', 'Le todo $name est supprimé avec succès!');
                $session->set('todos', $todos);
            }
        }else{
            $this->addFlash('error',"La liste des todos n'est pas encore initialisée ");
        }

        return $this->redirectToRoute('app_todo');

    }

    #[Route("/todo/reset",name:'reset_todo')]
    public function resetTodo(Request $request): RedirectResponse{
        //verification de l'existance d'un tableau todo et de l'initialisation des nouveaux éléments 
        $session = $request->getSession();
        $session->remove('$todos');
        return $this->redirectToRoute('app_todo');

    }
    #[Route("/multiplication/{a}/{b}",
    name:'mulit',
    requirements:["a"=>"\d+", "b"=>"\d+"]
    )]
    public function mlt($a,$b){
        $result = $a*$b;
        return new Response("<h1 color='red'>$result</h1>");
    }
    
}