<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Station; // adapte selon tes entités
use App\Entity\StationMeteos;
use PDO;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface; 

class ImportFromOldStationFixture extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['db_import'];
    }

    public function load(ObjectManager $manager)
    {
        // Connexion à l'ancienne base (exemple MySQL)
        $pdo = new PDO('mysql:host=127.0.0.1:3306;dbname=meteospit_2_old', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupère les données
        $stmt = $pdo->query('SELECT * FROM station');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $station = new Station();
            $station->setTemperature($row['temperature']);
            $station->setHumiditer($row['humiditer']);
            $station->setPression($row['pression']);
            $station->setLumiere($row['lumiere']);
            $station->setPointRosee($row['point_rosee']);
            $station->setAnemometre($row['anemometre']);
            $station->setGirouette($row['girouette']);
            $station->setPluviometre($row['pluviometre']);
            $station->setTpsvie(0);
            $station->setGhost(0);
            
            
            // Conversion de la date
            if (!empty($row['date_heure'])) {
                $station->setDateHeure(new \DateTime($row['date_heure']));
            }

            // Récupération de l'entité StationMeteos (exemple avec ID 2)
            $stationMeteo = $manager->getRepository(StationMeteos::class)->find(2);
            
            if ($stationMeteo) {
                $station->setStationMeteos($stationMeteo);
            }
            
            // ... autres setters selon tes champs ...
            $manager->persist($station);
        }

        $manager->flush();
    }
}