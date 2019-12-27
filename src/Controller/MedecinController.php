<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Geneteur\Matricule_genere;
use App\Repository\MedecinRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MedecinController extends AbstractController
{

    /**
     * @Route("/medecin", name="medecin.index")
     */
    public function index(MedecinRepository $medecinRepository)
    {
        $medecins=$medecinRepository->findAll();
        return $this->render('medecin/index.html.twig', [
            'medecins'=>$medecins,
             
        ]);
    }
    /**
     * @Route("/medecin/new", name="medecin")
     */
    public function new(Request $request,Matricule_genere $matGener)
    {
        // dump($matGener);
      
        $medecin=new Medecin();
        $form=$this->createForm(MedecinType::class,$medecin);

        if ($request->isMethod('POST') && $form->handleRequest($request)) {
            $on=$this->getDoctrine()->getManager();
             $medecin->setMatricule($matGener->generer($medecin));
            $on->persist($medecin);
            $on->flush();
            return $this->redirectToRoute('medecin.index');
        }

        return $this->render('medecin/new.html.twig', [
            'form'=>$form->createView(),
            // 'matricule'=>$matGener->generer($medecin)
        ]);
    }

     /**
     * @Route("/medecin/delete{id}", name="medecin.delete")
     */
    public function delete($id ,MedecinRepository $repos )
    {
        $medecin = $repos->find($id);
        // if (count($specialite->getServices()->getLibser())>0) {
        //    $this->addFlash(
        //        'warning',
        //        "Impossible De Supprimer le specialite<stong>{$specialite->getLibsp()}</strong> Car il ya 
        //        des specialites dans cet specialite"
        //    );
        // }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($medecin);
            $manager->flush();
            $this->addFlash(
                'success',
                " Le Medecin<stong>{$medecin->getMatricule()}</strong> Supprimer avec success"
            );


         
        return $this->redirectToRoute('medecin.index');
    }


      /**
     * @Route("/medecin/edite{id}", name="medecin.edite")
     */
    public function edite(Medecin $medecin ,Request $request){

        $form=$this->createForm(MedecinType::class, $medecin);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $on=$this->getDoctrine()->getManager();
            $on->persist($medecin);
            $on->flush();
         
            return $this->redirectToRoute('medecin.index');

        }
        return $this->render('medecin/edite.html.twig', [
            'medecin' =>$medecin,
            'form'=>$form->createView()
            
        ]);
    }
}
