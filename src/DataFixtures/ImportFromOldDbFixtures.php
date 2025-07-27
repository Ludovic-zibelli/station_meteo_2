<?php

namespace App\DataFixtures;

use App\Entity\MiniMaxi;
use App\Entity\StationMeteos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PDO;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface; 

class ImportFromOldDbFixtures extends Fixture implements FixtureGroupInterface
{

        public static function getGroups(): array
    {
        return ['db_importmini'];
    }

    public function load(ObjectManager $manager)
    {
        // Connexion à l'ancienne base de données

        // Connexion à l'ancienne base (exemple MySQL)
        $pdo = new PDO('mysql:host=127.0.0.1:3306;dbname=meteospit_2_old', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération des données
        $stmt = $pdo->query('SELECT * FROM mini_maxi');

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $station = new MiniMaxi();
            $station->setMiniTemp($row['mini_temp']);
            $station->setMaxiTemp($row['maxi_temp']);
            $station->setMiniHumi($row['mini_humi']);
            $station->setMaxiHumi($row['maxi_humi']);
            $station->setMiniPres($row['mini_pres']);
            $station->setMaxiPres($row['maxi_pres']);
            $station->setMiniLumi($row['mini_lumi']);
            $station->setMaxiLumi($row['maxi_lumi']);
            $station->setMiniPtro($row['mini_ptro']);
            $station->setMaxiPtro($row['maxi_ptro']);
            $station->setMiniAnemo($row['mini_anemo']);
            $station->setMaxiAnemo($row['maxi_anemo']);
            $station->setMiniGirou($row['mini_girou']);
            $station->setMaxiGirou($row['maxi_girou']);
            $station->setMiniPluvio($row['mini_pluvio']);
            $station->setMaxiPluvio($row['maxi_pluvio']);

            // Conversion de la date
            if (!empty($row['creatd_at'])) {
                $station->setCreatdAt(new \DateTime($row['creatd_at']));
            }

            // Récupération de l'entité StationMeteos (exemple avec ID 2)
            $stationMeteo = $manager->getRepository(StationMeteos::class)->find(2);
            if ($stationMeteo) {
                $station->setStationMeteos($stationMeteo);
            }

            $manager->persist($station);
        }

        $manager->flush();
    }
}
