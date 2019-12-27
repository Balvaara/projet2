<?php

namespace App\Geneteur;

use App\Entity\Medecin;
use App\Repository\MedecinRepository;

class Matricule_genere{

    private $matricule;

    public function __construct(MedecinRepository $medecinRepository)
    {
        $mat_format="00000";

        $last=$medecinRepository->findOneBy([],['id'=>'desc']);

        if ($last!=null) {

            $lastId=$last->getId();

            $this->matricule=sprintf("%'.05d\n",$lastId +1);
        }
        else{
            $this->matricule=sprintf("%'.05d\n",1);
        }

    }

    public function generer(Medecin $medecin){
        $indece='M';

        $service=$medecin->getServices()->getLibser();

        $nombre_de_lettre=(str_word_count($service,1));

        if (count($nombre_de_lettre)>=2) {
            foreach ($nombre_de_lettre as $k=>$v){
                $indece.=strtoupper(substr($v,0,1));
            }
        }else{
            $indece.=strtoupper(substr($nombre_de_lettre[0],0,1));
        }

        return $indece.$this->matricule;
    }
}