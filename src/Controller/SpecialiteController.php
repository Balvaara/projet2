<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialiteController extends AbstractController
{
    /**
     * @Route("/specialite", name="specialite.index")
     */
    public function index(SpecialiteRepository $specialiteRepository)
    {
        $specialite=$specialiteRepository->findAll();
        return $this->render('specialite/index.html.twig', [
            'specialites'=>$specialite,
        ]);
    }
    /**
     * @Route("/specialite/new", name="specialite.new")
     */
    public function new(Request $request)
    {
        $on=$this->getDoctrine()->getManager();
        $specialite=new Specialite();
        $form=$this->createForm(SpecialiteType::class,$specialite);
        if ($request->isMethod('POST') && $form->handleRequest($request)) {
            $on->persist($specialite);
            $on->flush();
            return $this->redirectToRoute('specialite.index');

        }
        return $this->render('specialite/new.html.twig', [
            'form'=>$form->createView(),
        ]);
    }


     /**
     * @Route("/specialite/delete{id}", name="specialite.delete")
     */
    public function delete($id ,SpecialiteRepository $repos )
    {
        $specialite = $repos->find($id);
        // if (count($specialite->getServices()->getLibser())>0) {
        //    $this->addFlash(
        //        'warning',
        //        "Impossible De Supprimer le specialite<stong>{$specialite->getLibsp()}</strong> Car il ya 
        //        des specialites dans cet specialite"
        //    );
        // }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($specialite);
            $manager->flush();
            $this->addFlash(
                'success',
                " Specialite<stong>{$specialite->getLibsp()}</strong> Supprimer avec success"
            );
            
        
         
        return $this->redirectToRoute('specialite.index');
    }


      /**
     * @Route("/specialite/edite{id}", name="specialite.edite")
     */
    public function edite(Specialite $specialite ,Request $request){

        $form=$this->createForm(SpecialiteType::class, $specialite);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()  && $form->isValid()) {
            $on=$this->getDoctrine()->getManager();
            $on->persist($specialite);
            $on->flush();
            $this->addFlash(
                'success',
                "good"
            );
            return $this->redirectToRoute('specialite.index');

        }
        return $this->render('specialite/edite.html.twig', [
            'specialite' =>$specialite,
            'form'=>$form->createView()
        ]);
    }

}
