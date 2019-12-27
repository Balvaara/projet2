<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service.index")
     */
    public function index(ServiceRepository $serviceRepository)
    {
        $services=$serviceRepository->findAll();
        return $this->render('service/index.html.twig', [
            'service'=>$services,
            
        ]);
    }
    /**
     * @Route("/service/new", name="service")
     * @return Response
     */
    public function new(Request $request):Response
    {
       
        //on cree un service

        $service= new Service();
        //on reccupere le formulaire
        $form=$this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()  && $form->isValid()) {
            $on=$this->getDoctrine()->getManager();

            $on->persist($service);
            $on->flush();
            $this->addflash("success",
            "Ajouter avec success"
        );
            return $this->redirectToRoute('service.index');

        }
        return $this->render('service/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    

     /**
     * @Route("/service/delete{id}", name="service.delete")
     */
    public function delete($id ,ServiceRepository $repos )
    {
        $service = $repos->find($id);
        if (count($service->getSpecialites())>0) {
           $this->addFlash(
               'warning',
               "Impossible De Supprimer le Service<stong>{$service->getLibser()}</strong> Car il ya 
               des specialites dans cet Service"
           );
        }else{
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($service);
            $manager->flush();
            $this->addFlash(
                'success',
                " Service<stong>{$service->getLibser()}</strong> Supprimer avec success"
            );
            
        }
         
        return $this->redirectToRoute('service.index');
    }


      /**
     * @Route("/service/edite{id}", name="service.edite")
     */
    public function edite(Service $service ,Request $request){

        $form=$this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()  && $form->isValid()) {
            $on=$this->getDoctrine()->getManager();
            $on->persist($service);
            $on->flush();
            $this->addFlash(
                'success',
                "good"
            );
            return $this->redirectToRoute('service.index');

        }
        return $this->render('service/edite.html.twig', [
            'service' =>$service,
            'form'=>$form->createView()
        ]);
    }

}
