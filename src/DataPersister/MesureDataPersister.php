<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\StationDirect;
use App\Notification\AlerteMeteoNotification;
use App\Notification\MiniMaxiANotification;
use App\Notification\MiniMaxiNotification;
use App\Repository\OragesRepository;
use App\Repository\VigilanceMeteofranceRepository;

class MesureDataPersister implements DataPersisterInterface
{
    private $decorated;
    private $miniMaxiNotification;
    private $miniMaxiANotification;
    private $alerteMeteo;
    private $vigilanceRepo;
    private $orages;


    public function __construct(DataPersisterInterface $decorated, MiniMaxiNotification $miniMaxiNotification, MiniMaxiANotification $miniMaxiANotification, AlerteMeteoNotification $alerteMeteo, VigilanceMeteofranceRepository $vigilanceRepo, OragesRepository $orages)
    {
            $this->decorated = $decorated;
            $this->miniMaxiNotification = $miniMaxiNotification;
            $this->miniMaxiANotification = $miniMaxiANotification;
            $this->alerteMeteo = $alerteMeteo;
            $this->vigilanceRepo = $vigilanceRepo;
            $this->orages = $orages;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof StationDirect;
    }

    public function persist($data, array $context = [])
    {
        $this->miniMaxiNotification->getMinimaxi($data);
        $this->miniMaxiANotification->minimaxicompare($data);
        $this->alerteMeteo->calculAlerteTempAuto($data->getTempbmp280());
        //$this->alerteMeteo->vigilanceMeteoFrance();
        
        
        // Récupère la dernière vigilance (par exemple la plus récente)
        $vigilance = $this->vigilanceRepo->findOneBy([], ['start_time' => 'DESC']);
        
        
        if ($vigilance) {
            $data->setAlerteMeteoFrance($vigilance->getText1());
            $data->setCouleurMeteoFrance($vigilance->getRiskCode());
            $data->setDateDebutMeteoFrance($vigilance->getStartTime());
            $data->setDateFinMeteoFrance($vigilance->getEndTime());
        } else {
            $data->setAlerteMeteoFrance(null);
            $data->setCouleurMeteoFrance(null);
            $data->setDateDebutMeteoFrance(null);
            $data->setDateFinMeteoFrance(null);
        }
        
       // Récupère les données des orages pour chaque radius (1, 10, 50)
        $orages1 = $this->orages->findOneBy(['radius' => 1]);
        $orages10 = $this->orages->findOneBy(['radius' => 10]);
        $orages50 = $this->orages->findOneBy(['radius' => 50]);

        // Exemple : on utilise le total_strikes pour chaque radius
        $data->setEclaire1Km($orages1 ? $orages1->getTotalStrikes() : 0);
        $data->setEclaire10Km($orages10 ? $orages10->getTotalStrikes() : 0);
        $data->setEclaire50Km($orages50 ? $orages50->getTotalStrikes() : 0);

  
                        
       // Création fichier JSON à partir de $data
        $dataArray = [
            'dateheure' => $data->getDateheure(), // adapte si le getter s'appelle différemment
            'temp1' => $data->getTempbmp280(),
            'humiditer' => $data->getHumidite(),
            'temp2' => $data->getTempdh22(),
            'pression' => $data->getPression(),
            'lumiere' => $data->getLumiere(),
            'pluvio' => $data->getPluviometre(),
            'anemo' => $data->getAnemometre(),
            'girou' => $data->getGirouette(),
            'pt_rosee' => $data->getPointrose(),
            'bitvie' => $data->getTpsvie(),
            // Ajoute ici d'autres champs si besoin
            'eclaire_1km' => $data->getEclaire1Km(),
            'eclaire_10km' => $data->getEclaire10Km(),
            'eclaire_50km' => $data->getEclaire50Km(),
            'vgilance' => $data->getAlerteMeteoFrance(),
            'vigilancedebut' => $data->getDateDebutMeteoFrance(),
            'vigilancefin' => $data->getDateFinMeteoFrance(),
            'vigilancecouleur' => $data->getCouleurMeteoFrance(),
            
        ];

        file_put_contents('stationdirect.json', json_encode($dataArray, JSON_PRETTY_PRINT));
    

        return $this->decorated->persist($data, $context);
      
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}