<?php

namespace App\Notification;

class SaisonNotification
{

    private $anim_lumi;

    private $prevision;

    private $saison;

    private $barometre;

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

    public function saison()
    {
        $jourMois = date("z");


        //Saison defini en nombre de jour
        //Hiver du 21 decembre au 31 decembre
        if ($jourMois > 352 && $jourMois <365){
            $this->saison = 'hiver';
        }

        //Ete du 20 juin au 22 septembre
        if ($jourMois>= 170 && $jourMois <=262){
            $this->saison = 'ete';
        }

        //Automne du 22 septembre au 21 decembre
        if ($jourMois>= 263 && $jourMois <=351){
            $this->saison = 'automne';
        }

        //Printemps du 20 mars au 20 juin
        if ($jourMois>= 78 && $jourMois <=169){
            $this->saison = 'printemps';
        }

        //Hiver du 1 janvier au 20 mars
        if ($jourMois>= 0 && $jourMois <=77){
            $this->saison = 'hiver';
        }

        return $this->saison;
    }

    public function previsions()
    {

        //Lecture d'un fichier .txt ligne par ligne et stokage dans un tableau
        # Chemin vers fichier texte
        $file ="station_direct.txt";
        # On met dans la variable (tableau $read) le contenu du fichier
        $read=file($file);
        //tranformation nombre pression a virgule en entier pour variable prevision
        $pression2 = intval($read[5]);
        $saison = $this->saison();


        //Prevision par la pression Printemps
        if($saison == 'printemps'){
            if($pression2 >= 1020){
                $this->prevision = 'Beau assez beau. Journées douces ou assez chaudes, nuits fraiches gelées possibles.';
                $this->barometre = 'soleil.jpeg';
            }


            if($pression2>= 1014 && $pression2 <1020){
                $this->prevision = 'Giboulées. Journées fraiches, nuits froide gelées à  craindre.';
                $this->barometre = 'nuage_soleil.jpeg';
            }

            if($pression2>= 1005 && $pression2<=1013){
                $this->prevision = 'Ondées ou giboulées avec vent. Temps frais.';
                $this->barometre = 'nuage1.jpeg';
            }

            if($pression2 <= 1006){
                $this->prevision = 'Ondées giboulées ou averses orageuses; Neige en Montagne. Vent faible ou modérai. Temperatures basses.';
                $this->barometre = 'nuage_pluie.jpeg';
            }

            //if($pression2 >= 1013 && $evolution_press >= 2)
            //{
            //	$prevision = 'Amelioration du temp.';
            //	$barometre = 'nuagesoleil1.jpeg';
            //}

            //if($pression2 <= 1013 && $evolution_press <= 2)
            //{
            //	$prevision = 'ATTENTION RISQUE D ORAGE ET DE PLUIE';
            //	$barometre = 'orage_pluie.jpeg';
            //}

        }

        //Prevision pression Ete
        if($saison == 'ete'){
            if($pression2 >= 1020){
                $this->prevision = 'Beau. Journées chaudes, Nuits fraiches.';
                $this->barometre = 'soleil.jpeg';
            }


            if($pression2>= 1014 && $pression2 <1020){
                $this->prevision = 'Beau ou assez beau avec parfois des averses orageuses. Chaud ou assez chaud le jour, nuit fraiches.';
                $this->barometre = 'nuage_soleil.jpeg';

            }

            if($pression2>= 1005 && $pression2 <=1013){
                $this->prevision = 'Pluies orageuses. Temperature douces.';
                $this->barometre = 'nuagesoleilpluie.jpeg';
            }

            if($pression2 <= 1006){
                $this->prevision = 'Pluies orageuses avec un peu de vent. Temps lourd et humide.';
                $this->barometre = 'orage_pluie.jpeg';
            }

        }

        //Prevision automne
        if($saison == 'automne'){
            if($pression2 >= 1020){
                $this->prevision = 'Beau assez beau. Chaleur modérai. Gelées Ã  craindre.';
                $this->barometre = 'soleil.jpeg';
            }


            if($pression2> 1014 && $pression2 <=1019){
                $this->prevision = 'Assez beau avec possibilité d\ondÃ©es. Frais le jour et gelées locales.';
                $this->barometre = 'nuage_soleil.jpeg';
            }

            if($pression2>= 1007 && $pression2<=1013){
                $this->prevision = 'Ondées en plaine. Giboulées en montagne. Temps frais.';
                $this->barometre = 'nuagesoleilpluie.jpeg';
            }

            if($pression2 <= 1006){
                $this->prevision = 'Averses orageuses et vent modérai. Temps frais.';
                $this->barometre = 'orage_pluie.jpeg';
            }

        }

        //Prevision Hiver
        if($saison == 'hiver'){
            if($pression2 >= 1020){
                $this->prevision= 'Beau ou assez beau, un peu brumeux. Journées froides et gelées nocturnes.';
                $this->barometre = 'soleil.jpeg';
            }


            if($pression2> 1014 && $pression2 <1019){
                $this->prevision= 'Temps brumeux; giboulées ou neige. Temperature froide';
                $this->barometre = 'nuage_soleil.jpeg';
            }

            if($pression2> 1007 && $pression2<1013){
                $this->prevision= 'Neige ou giboulées. Temperature froide';
                $this->barometre = 'neige1.jpeg' ;
            }

            if($pression2 <= 1006){
                $this->prevision = 'Giboulées neige possible; Vent modéré à  assez fort. Temperature froide';
                $this->barometre = 'neige1.jpeg' ;
            }

        }
        return array($this->prevision, $this->barometre);
    }
}