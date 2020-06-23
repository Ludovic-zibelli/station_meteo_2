<?php

namespace App\Notification;

class SaisonNotification
{

    private $anim_lumi;

    public function AnimationLumiere()
    {
        //Lecture d'un fichier .txt ligne par ligne et stokage dans un tableau
        # Chemin vers fichier texte
        $file ="station_direct.txt";
        # On met dans la variable (tableau $read) le contenu du fichier
        $read=file($file);


        //Annimation levee coucher de soleil
        //Definition avant midi apres midi
        $am_pm = date("a");
        //Calcul taux d'ensoilement
        $a = (int)$read[10] * 100;
        $taux = $a / 5;


        //avant midi
        if($am_pm == "am"){
            if($taux <= 10){
                $this->anim_lumi = 'anim_lev_couch_00.jpg';
            }

            if($taux>= 11 && $taux<= 39){
                $this->anim_lumi = 'anim_lev_couch_6.jpg';
            }

            if($taux>= 40 && $taux<= 59){
                $this->anim_lumi = 'anim_lev_couch_8.jpg';
            }

            if($taux>= 60 && $taux<= 84){
                $this->anim_lumi = 'anim_lev_couch_12.jpg';
            }

            if($taux > 85){
                $this->anim_lumi = 'anim_lev_couch_12.jpg';
            }

        }


        //Apres midi
        if($am_pm == "pm"){


            if($taux <= 10){
                $this->anim_lumi = 'anim_lev_couch_00.jpg';
            }

            if($taux>= 11 && $taux <= 39){
                $this->anim_lumi = 'anim_lev_couch_20.jpg';
            }

            if($taux >= 40 && $taux<= 59){
                $this->anim_lumi = 'anim_lev_couch_16.jpg';
            }

            if($taux >= 60 && $taux <= 84){
                $this->anim_lumi = 'anim_lev_couch_12.jpg';
            }

            if($taux > 85){
                $this->anim_lumi = 'anim_lev_couch_12.jpg';
            }

        }
        return $this->anim_lumi;

    }
}