<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206180844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat_station_meteo (id INT AUTO_INCREMENT NOT NULL, station_meteo_id INT DEFAULT NULL, module_bmp280 INT DEFAULT NULL, module_dht22 INT DEFAULT NULL, module_anemo INT DEFAULT NULL, module_girou INT DEFAULT NULL, module_pluvio INT DEFAULT NULL, module_tension INT DEFAULT NULL, module_bitvie INT DEFAULT NULL, capteur_dht22 INT DEFAULT NULL, capteur_bmp280 INT DEFAULT NULL, capteur_pluvio INT DEFAULT NULL, capteur_girou INT DEFAULT NULL, capteur_anemo INT DEFAULT NULL, ghost INT DEFAULT NULL, log_date_bmp280 DATETIME DEFAULT NULL, log_bmp280 LONGTEXT DEFAULT NULL, log_date_dht22 DATETIME DEFAULT NULL, log_dht22 LONGTEXT DEFAULT NULL, log_date_girou DATETIME DEFAULT NULL, log_girou LONGTEXT DEFAULT NULL, log_date_tension DATETIME DEFAULT NULL, log_tension LONGTEXT DEFAULT NULL, log_date_anemo DATETIME DEFAULT NULL, log_anemo LONGTEXT DEFAULT NULL, log_date_pluvio DATETIME DEFAULT NULL, log_pluvio LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_73F50A3740FC9F8A (station_meteo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etat_station_meteo ADD CONSTRAINT FK_73F50A3740FC9F8A FOREIGN KEY (station_meteo_id) REFERENCES station_meteos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE etat_station_meteo');
    }
}
