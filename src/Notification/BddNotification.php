<?php

namespace App\Notification;

use App\Entity\MiniMaxi;
use App\Entity\MiniMaxiH;
use App\Entity\Station;
use App\Repository\MiniMaxiHRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StationDirectRepository;
use App\Repository\StationMeteosRepository;

class BddNotification
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var MiniMaxiHRepository
     */
    private $repo;
    /**
     * @var StationDirectRepository
     */
    private $repoDirect;

    /**
     * @var StationMeteosRepository
     */
    private $stationMeteosRepo;


    /**
     * BddNotification constructor.
     * @param EntityManagerInterface $em
     * @param MiniMaxiHRepository $repo
     * @param StationDirectRepository $repoDirect
     * @param stationMeteosRepository $stationMeteosRepo
     */
    public function __construct(EntityManagerInterface $em, MiniMaxiHRepository $repo, StationDirectRepository $repoDirect, StationMeteosRepository $stationMeteosRepo)
    {

        $this->em = $em;
        $this->repo = $repo;
        $this->repoDirect = $repoDirect;
        $this->stationMeteosRepo = $stationMeteosRepo;
    }

    //Enregistrement des donnée météo en bdd
    public function AddBddStation()
    {
        $dataRepo = $this->repoDirect->findAll();
        //tranformation nombre pression a virgule en entier pour variable prevision
        if (empty($dataRepo)) {
            return; // Évite une erreur si le tableau est vide
        }
       
        // Récupération de l'entité StationMeteo associée
        $stationMeteoId = $dataRepo[0]->getStationId();
        $stationMeteo = $this->stationMeteosRepo->find($stationMeteoId);

        if (!$stationMeteo) {
            return; // Si la station météo n'existe pas, on ne fait rien
        }
        
        // Vérifie si une entrée avec la même idStationMeteo et la même date existe déjà
        //'idStationMeteo' => $stationMeteo,  
        $existingStation = $this->em->getRepository(Station::class)->findOneBy([
            'date_heure' => $dataRepo[0]->getDateHeure() 
        ]);
        
        //dd($existingStation);
        if ($existingStation) {
            return; // Évite d'enregistrer un doublon
        }
        
        
        $station = new Station();
        //$stationMeteo = $dataRepo[0]->getStationMeteos();
        //dd($stationMeteo);
        $station->setDateHeure($dataRepo[0]->getDateHeure());
        $station->setTemperature($dataRepo[0]->getTempbmp280());
        $station->setHumiditer($dataRepo[0]->getHumidite());
        $station->setPression($dataRepo[0]->getPression());
        $station->setLumiere($dataRepo[0]->getLumiere());
        $station->setPointRosee($dataRepo[0]->getPointRose());
        $station->setGirouette($dataRepo[0]->getGirouette());
        $station->setPluviometre($dataRepo[0]->getPluviometre());
        $station->setAnemometre($dataRepo[0]->getAnemometre());
        //dd($dataRepo[0]->getStationId());
        $station->setStationMeteos($stationMeteo);
        $station->setTpsvie($dataRepo[0]->getTpsvie());
        $station->setGhost($dataRepo[0]->getGhost());
        $this->em->persist($station);
        $this->em->flush();
    }

    //Sauvegarde mini maxi journaliere
    public function AddBddMiniMaxi($stationId = 2)
    {
        // Récupère la station météo
        $stationMeteo = $this->stationMeteosRepo->find($stationId);
        if (!$stationMeteo) {
            return;
        }

        // Récupère les valeurs mini/maxi actuelles
        $minimaxih = $this->repo->findBy(['stationMeteos' => $stationMeteo]);
        if (empty($minimaxih)) {
            return;
        }

        // Récupère le dernier MiniMaxi enregistré pour cette station

        $lastMiniMaxi = $this->em->getRepository(MiniMaxi::class)
            ->findOneBy(['stationMeteos' => $stationMeteo], ['id' => 'DESC']);

        // Vérifie s'il y a eu un changement
        $hasChanged = false;
        if ($lastMiniMaxi) {
            $fields = [
                'MiniTemp', 'MaxiTemp', 'MiniHumi', 'MaxiHumi', 'MiniPres', 'MaxiPres',
                'MiniLumi', 'MaxiLumi', 'MiniPtro', 'MaxiPtro', 'MiniPluvio', 'MaxiPluvio',
                'MiniGirou', 'MaxiGirou', 'MiniAnemo', 'MaxiAnemo'
            ];
            foreach ($fields as $field) {
                $getter = 'get' . $field;
                if ($minimaxih[0]->$getter() !== $lastMiniMaxi->$getter()) {
                    $hasChanged = true;
                    break;
                }
            }
        } else {
            $hasChanged = true; // Aucun enregistrement précédent
        }

        // Si changement, on sauvegarde
        if ($hasChanged) {
            $minimaxi = new MiniMaxi();
            $minimaxi->setStationMeteos($stationMeteo);
            $minimaxi->setMiniTemp($minimaxih[0]->getMiniTemp());
            $minimaxi->setMaxiTemp($minimaxih[0]->getMaxiTemp());
            $minimaxi->setMiniHumi($minimaxih[0]->getMiniHumi());
            $minimaxi->setMaxiHumi($minimaxih[0]->getMaxiHumi());
            $minimaxi->setMiniPres($minimaxih[0]->getMiniPres());
            $minimaxi->setMaxiPres($minimaxih[0]->getMaxiPres());
            $minimaxi->setMiniLumi($minimaxih[0]->getMiniLumi());
            $minimaxi->setMaxiLumi($minimaxih[0]->getMaxiLumi());
            $minimaxi->setMiniPtro($minimaxih[0]->getMiniPtro());
            $minimaxi->setMaxiPtro($minimaxih[0]->getMaxiPtro());
            $minimaxi->setMiniPluvio($minimaxih[0]->getMiniPluvio());
            $minimaxi->setMaxiPluvio($minimaxih[0]->getMaxiPluvio());
            $minimaxi->setMiniGirou($minimaxih[0]->getMiniGirou());
            $minimaxi->setMaxiGirou($minimaxih[0]->getMaxiGirou());
            $minimaxi->setMiniAnemo($minimaxih[0]->getMiniAnemo());
            $minimaxi->setMaxiAnemo($minimaxih[0]->getMaxiAnemo());
            $this->em->persist($minimaxi);
            $this->em->flush();
        }
        
    }

    
/**
     * Réinitialise MiniMaxiH pour une station avec les valeurs capteurs courantes :
     * mini = maxi = valeur instantanée au moment de l'appel.
     */
    public function resetMiniMaxiHFromSensors(int $stationId = 2): void
    {
        // 1) Charger la station
        $stationMeteo = $this->stationMeteosRepo->find($stationId);
        if (!$stationMeteo) {
            return;
        }

        // 2) Dernière mesure StationDirect pour cette station
        //    (la plus récente par dateheure)
        $last = $this->repoDirect->findOneBy(
            ['station_id' => $stationId],     // <-- dans ton entité StationDirect tu as bien station_id
            ['dateheure' => 'DESC']
        );
        if (!$last) {
            return; // rien à “réinitialiser” si aucune mesure
        }

        // 3) Tenter de récupérer un MiniMaxiH existant (le plus récent)
        //    NB: on filtre par la RELATION et pas par l'ID (on passe $stationMeteo)
        $currentH = $this->repo->findOneBy(
            ['stationMeteos' => $stationMeteo],
            ['id' => 'DESC']
        );

        if (!$currentH) {
            $currentH = new MiniMaxiH();
            $currentH->setStationMeteos($stationMeteo);
        }

        // 4) Récupérer les valeurs courantes venant de StationDirect
        //    (les champs existent tels quels dans ta classe StationDirect)
        $temp    = $last->getTempbmp280();
        $humi    = $last->getHumidite();
        $pres    = $last->getPression();
        $lumi    = $last->getLumiere();
        $ptro    = $last->getPointRose();     // point de rosée (string dans ton entité ; si c'est string, caster si besoin)
        $pluvio  = $last->getPluviometre();
        $girou   = $last->getGirouette();
        $anemo   = $last->getAnemometre();

        // 5) Injecter "mini = maxi = valeur courante"
        //    (setters déjà utilisés dans AddBddMiniMaxi => ils existent sur MiniMaxiH)
        $currentH->setMiniTemp($temp);
        $currentH->setMaxiTemp($temp);

        $currentH->setMiniHumi($humi);
        $currentH->setMaxiHumi($humi);

        $currentH->setMiniPres($pres);
        $currentH->setMaxiPres($pres);

        $currentH->setMiniLumi($lumi);
        $currentH->setMaxiLumi($lumi);

        // ptro (point de rosée) : selon ton mapping, si ce champ est float/décimal dans MiniMaxiH,
        // et que StationDirect le fournit en string, pense à le normaliser (floatval)
        $ptroFloat = is_null($ptro) ? null : (float) $ptro;
        $currentH->setMiniPtro($ptroFloat);
        $currentH->setMaxiPtro($ptroFloat);

        $currentH->setMiniPluvio($pluvio);
        $currentH->setMaxiPluvio($pluvio);

        $currentH->setMiniGirou($girou);
        $currentH->setMaxiGirou($girou);

        $currentH->setMiniAnemo($anemo);
        $currentH->setMaxiAnemo($anemo);

        // 6) Persister
        $this->em->persist($currentH);
        $this->em->flush();
    }

}