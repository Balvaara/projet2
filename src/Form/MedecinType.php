<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MedecinType extends AbstractType
{
    // private $serRepo;

    // public function  __construct(ServiceRepository $serRepo){

    //     $this->serRepo=$serRepo;
    // }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule',HiddenType::class)
            ->add('nom',TextType::class, [
                'required' => true,
                'constraints' => [new Length(['max' => 20])],
                'attr'=>[
                    'placeholder'=>'Le Nom SVP'
                ]
                
            ])
            ->add('prenom',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Le Prenom SVP'
                ]
            ])
            ->add('datenaiss',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('tel',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'+221....'
                ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'Le Email SVP'
                ]
            ])
            ->add('adresse',TextType::class,[
                'attr'=>[
                    'placeholder'=>'L\'adresse SVP'
                ]   
            ])
            ->add('services',EntityType::class,[
                'class'=>Service::class,
                'choice_label'=>'libser'
            ])
             ->add('specialites',EntityType::class,[
                'class'=>Specialite::class,
                'choice_label'=>'libsp',
                'multiple'=>true,
                'required' => true,
                'expanded'=>true,
                'by_reference'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
