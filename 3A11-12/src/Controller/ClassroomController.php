<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ClassroomFormType;


class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/afficheC', name: 'app_afficheC')]
    public function afficheC(): Response
    {
        $classrooms=$this->getDoctrine()
        ->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/afficheC.html.twig', ['c'=>$classrooms
            
        ]);
    }
    #[Route('/suppClassroom/{id}', name: 'suppC')]
    public function suppClassroom($id,ClassroomRepository $r,
    ManagerRegistry $doctrine): Response
    { //récupérer la classroom à supprimer
    $classroom=$r->find($id);
    //Action suppression
     $em =$doctrine->getManager();
     $em->remove($classroom);
     $em->flush();
return $this->redirectToRoute('app_afficheC');
}

#[Route('/addC', name: 'addClassroom')]
public function addClassroom(ManagerRegistry $doctrine,Request $request)
               {
$classroom= new Classroom();
$form=$this->createForm(ClassroomFormType::class,$classroom);
                   $form->handleRequest($request);
                   if($form->isSubmitted()){
                       $em =$doctrine->getManager() ;
                       $em->persist($classroom);
                       $em->flush();
                       return $this->redirectToRoute("app_afficheC");}
              return $this->renderForm("classroom/addClassroom.html.twig",
                       array("f"=>$form));
                }


        #[Route('/updateC/{id}', name: 'updateClassroom')]
        public function modifierClassroom(ManagerRegistry $doctrine,Request $request,$id,ClassroomRepository $r)
                               {
              { //récupérer la classroom à modifier
                $classroom=$r->find($id);
            $form=$this->createForm(ClassroomFormType::class,$classroom);
             $form->handleRequest($request);
             if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
                 $em->flush();
                                       return $this->redirectToRoute("app_afficheC");}
                              return $this->renderForm("classroom/addClassroom.html.twig",
                                       array("f"=>$form));
                                }
                            }

     #[Route('/afficheS', name: 'afficheS')]

   public function afficheS(StudentRepository $repository)
                                                  {
   //Afficher tous les étudiants
    $s= $repository->findAll();
 //Afficher les étudiants ordonés par mail
$so=$repository->orderByMail();
 return $this->render("student/afficheS.html.twig",
   ["students"=>$s,"so"=>$so]);
 }
 #[Route('/searchStudentByAVG', name: 'searchStudentByAVG')]
 public function searchStudentByAVG(Request $request,StudentRepository $student){

         $students= $student->orderByMail();
         $searchForm = $this->createForm(SearchStudentFormType::class);
         $searchForm->handleRequest($request);
         if ($searchForm->isSubmitted()) {
         //récupérer le contenu de l'input min
             $minMoy=$searchForm['min']->getData();
             $maxMoy=$searchForm['max']->getData();
             $resultOfSearch = $student->findStudentByAVG($minMoy,$maxMoy);
             return $this->renderForm('student/searchStudentByAVG.html.twig', [
                 'Students'=>$resultOfSearch,
                 'searchStudentByAVG' => $searchForm,]);
         }
return $this->renderForm('student/searchStudentByAVG.html.twig',
array('Students' => $students,'searchStudentByAVG'=>$searchForm,
             ));

}

}
