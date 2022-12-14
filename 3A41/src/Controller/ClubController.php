<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => '3A41',
        ]);
    }

      #[Route('/get/{nom}', name: 'app_club1')]
        public function getName($nom): Response
        {
            return $this->render('club/detail.html.twig', [
                'n' =>$nom
            ]);
        }

        #[Route('/list', name: 'app_club2')]
                public function list(): Response
                {
                $formations = array( array('ref' => 'f1', 'Titre' => 'Formation Symfony 4','Description'=>'formation pratique','nb_participants'=>19) ,
                array('ref'=>'f2','Titre'=>'Formation SOA' , 'Description'=>'formation theorique','nb_participants'=>0),
                 array('ref'=>'f3','Titre'=>'Formation Angular' , 'Description'=>'formation theorique','nb_participants'=>12));
                    return $this->render('club/list.html.twig', [
                        'f' =>$formations,
                    ]);
                }

         #[Route('/detail/{titre}/{nbP}', name: 'detailF')]
           public function detail($titre,$nbP): Response
                    {
                        return $this->render('club/detail.html.twig', [
                            't' => $titre,'n'=>$nbP,
                        ]);
                    }
}
