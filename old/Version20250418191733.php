<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418191733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alert_meteo (id INT AUTO_INCREMENT NOT NULL, creatd_at DATETIME NOT NULL, type TINYINT(1) NOT NULL, online TINYINT(1) NOT NULL, level INT NOT NULL, message LONGTEXT NOT NULL, pictogramme VARCHAR(255) DEFAULT NULL, code_phenomene INT DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arcticles (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, titre VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, auteur VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, online TINYINT(1) NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4473CEFA12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, arcticles_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, online TINYINT(1) NOT NULL, signaler TINYINT(1) NOT NULL, INDEX IDX_D9BEC0C44267E934 (arcticles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_station_meteo (id INT AUTO_INCREMENT NOT NULL, station_meteo_id INT NOT NULL, module_bmp280 INT DEFAULT NULL, module_dht22 INT DEFAULT NULL, module_anemo INT DEFAULT NULL, module_girou INT DEFAULT NULL, module_pluvio INT DEFAULT NULL, module_tension INT DEFAULT NULL, module_bitvie INT DEFAULT NULL, capteur_dht22 INT DEFAULT NULL, capteur_bmp280 INT DEFAULT NULL, capteur_pluvio INT DEFAULT NULL, capteur_girou INT DEFAULT NULL, capteur_anemo INT DEFAULT NULL, ghost INT DEFAULT NULL, log_date_bmp280 DATETIME DEFAULT NULL, log_bmp280 LONGTEXT DEFAULT NULL, log_date_dht22 DATETIME DEFAULT NULL, log_dht22 LONGTEXT DEFAULT NULL, log_date_girou DATETIME DEFAULT NULL, log_girou LONGTEXT DEFAULT NULL, log_date_tension DATETIME DEFAULT NULL, log_tension LONGTEXT DEFAULT NULL, log_date_anemo DATETIME DEFAULT NULL, log_anemo LONGTEXT DEFAULT NULL, log_date_pluvio DATETIME DEFAULT NULL, log_pluvio LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_73F50A3740FC9F8A (station_meteo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mini_maxi (id INT AUTO_INCREMENT NOT NULL, mini_temp VARCHAR(255) NOT NULL, maxi_temp VARCHAR(255) NOT NULL, mini_humi VARCHAR(255) NOT NULL, maxi_humi VARCHAR(255) NOT NULL, mini_pres VARCHAR(255) NOT NULL, maxi_pres VARCHAR(255) NOT NULL, mini_lumi VARCHAR(255) NOT NULL, maxi_lumi VARCHAR(255) NOT NULL, mini_ptro VARCHAR(255) NOT NULL, maxi_ptro VARCHAR(255) NOT NULL, mini_anemo VARCHAR(255) NOT NULL, maxi_anemo VARCHAR(255) NOT NULL, mini_girou VARCHAR(255) NOT NULL, maxi_girou VARCHAR(255) NOT NULL, mini_pluvio VARCHAR(255) NOT NULL, maxi_pluvio VARCHAR(255) NOT NULL, creatd_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mini_maxi_a (id INT AUTO_INCREMENT NOT NULL, mini_temp VARCHAR(255) NOT NULL, date_mini_temp DATETIME NOT NULL, maxi_temp VARCHAR(255) NOT NULL, date_maxi_temp DATETIME NOT NULL, mini_humi VARCHAR(255) NOT NULL, date_mini_humi DATETIME NOT NULL, maxi_humi VARCHAR(255) NOT NULL, date_maxi_humi DATETIME NOT NULL, mini_pres VARCHAR(255) NOT NULL, date_mini_pres DATETIME NOT NULL, maxi_pres VARCHAR(255) NOT NULL, date_maxi_pres DATETIME NOT NULL, mini_lumi VARCHAR(255) NOT NULL, date_mini_lumi DATETIME NOT NULL, maxi_lumi VARCHAR(255) NOT NULL, date_maxi_lumi DATETIME NOT NULL, mini_ptro VARCHAR(255) NOT NULL, date_mini_ptro DATETIME NOT NULL, maxi_ptro VARCHAR(255) NOT NULL, date_maxi_ptro DATETIME NOT NULL, mini_anemo VARCHAR(255) NOT NULL, date_mini_anemo DATETIME NOT NULL, maxi_anemo VARCHAR(255) NOT NULL, date_maxi_anemo DATETIME NOT NULL, mini_girou VARCHAR(255) NOT NULL, date_mini_girou DATETIME NOT NULL, maxi_girou VARCHAR(255) NOT NULL, date_maxi_girou DATETIME NOT NULL, mini_pluvio VARCHAR(255) NOT NULL, date_mini_pluvio DATETIME NOT NULL, maxi_pluvio VARCHAR(255) NOT NULL, date_maxi_pluvio DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mini_maxi_h (id INT AUTO_INCREMENT NOT NULL, mini_temp VARCHAR(255) NOT NULL, maxi_temp VARCHAR(255) NOT NULL, mini_humi VARCHAR(255) NOT NULL, maxi_humi VARCHAR(255) NOT NULL, mini_pres VARCHAR(255) NOT NULL, maxi_pres VARCHAR(255) NOT NULL, mini_lumi VARCHAR(255) NOT NULL, mini_ptro VARCHAR(255) NOT NULL, maxi_ptro VARCHAR(255) NOT NULL, mini_anemo VARCHAR(255) NOT NULL, maxi_anemo VARCHAR(255) NOT NULL, mini_girou VARCHAR(255) NOT NULL, maxi_girou VARCHAR(255) NOT NULL, mini_pluvio VARCHAR(255) NOT NULL, maxi_pluvio VARCHAR(255) NOT NULL, maxi_lumi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orages (id INT AUTO_INCREMENT NOT NULL, eclaires_1_km INT DEFAULT NULL, eclaire_10_km INT DEFAULT NULL, eclaires_50_km INT DEFAULT NULL, datetime DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, station_meteos_id INT NOT NULL, date_heure DATETIME NOT NULL, temperature INT NOT NULL, humiditer INT NOT NULL, pression INT NOT NULL, lumiere INT NOT NULL, anemometre INT NOT NULL, girouette INT NOT NULL, pluviometre INT NOT NULL, point_rosee VARCHAR(255) NOT NULL, tpsvie BIGINT NOT NULL, ghost INT NOT NULL, INDEX IDX_9F39F8B1EA5C2B84 (station_meteos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station_direct (id INT AUTO_INCREMENT NOT NULL, station_meteos_id INT NOT NULL, dateheure DATETIME NOT NULL, tempdh22 DOUBLE PRECISION NOT NULL, tempbmp280 DOUBLE PRECISION NOT NULL, humidite INT NOT NULL, pression DOUBLE PRECISION NOT NULL, lumiere DOUBLE PRECISION NOT NULL, anemometre DOUBLE PRECISION NOT NULL, girouette INT NOT NULL, pluviometre DOUBLE PRECISION NOT NULL, point_rose VARCHAR(255) NOT NULL, eclaire1km INT NOT NULL, eclaire10km INT NOT NULL, eclaire50km INT NOT NULL, alertemeteofrance VARCHAR(255) DEFAULT NULL, couleurmeteofrance VARCHAR(255) NOT NULL, datedebutmeteofrance DATETIME DEFAULT NULL, datefinmeteofrance DATETIME DEFAULT NULL, tpsvie BIGINT NOT NULL, ghost INT NOT NULL, station_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_EFF506A8EA5C2B84 (station_meteos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station_meteos (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_creation DATETIME NOT NULL, ville VARCHAR(255) NOT NULL, codepostal INT NOT NULL, gps_latitude DOUBLE PRECISION DEFAULT NULL, gps_longitude DOUBLE PRECISION DEFAULT NULL, lien_photo LONGTEXT DEFAULT NULL, lien_donnees LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, diy TINYINT(1) DEFAULT NULL, photo_name VARCHAR(255) DEFAULT NULL, photo_original_name VARCHAR(255) DEFAULT NULL, photo_mime_type VARCHAR(255) DEFAULT NULL, photo_size INT DEFAULT NULL, photo_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_1AB03F12A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vigilance_meteofrance (id INT AUTO_INCREMENT NOT NULL, domaine_id INT NOT NULL, domaine_name VARCHAR(255) NOT NULL, bloc_title LONGTEXT NOT NULL, bloc_id LONGTEXT NOT NULL, term_names VARCHAR(255) DEFAULT NULL, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, risk_name VARCHAR(255) DEFAULT NULL, risk_code INT DEFAULT NULL, risk_color VARCHAR(255) DEFAULT NULL, risk_level INT DEFAULT NULL, text_1 LONGTEXT DEFAULT NULL, text_2 LONGTEXT DEFAULT NULL, bold_text_1 VARCHAR(255) DEFAULT NULL, bold_text_2 VARCHAR(255) DEFAULT NULL, text_3 LONGTEXT DEFAULT NULL, text_4 LONGTEXT DEFAULT NULL, text_5 LONGTEXT DEFAULT NULL, text_6 LONGTEXT DEFAULT NULL, update_date DATETIME NOT NULL, hazard_code INT DEFAULT NULL, text21 LONGTEXT DEFAULT NULL, text22 LONGTEXT DEFAULT NULL, text23 LONGTEXT DEFAULT NULL, text24 LONGTEXT DEFAULT NULL, text25 LONGTEXT DEFAULT NULL, text26 LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arcticles ADD CONSTRAINT FK_4473CEFA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C44267E934 FOREIGN KEY (arcticles_id) REFERENCES arcticles (id)');
        $this->addSql('ALTER TABLE etat_station_meteo ADD CONSTRAINT FK_73F50A3740FC9F8A FOREIGN KEY (station_meteo_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A8EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station_meteos ADD CONSTRAINT FK_1AB03F12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arcticles DROP FOREIGN KEY FK_4473CEFA12469DE2');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C44267E934');
        $this->addSql('ALTER TABLE etat_station_meteo DROP FOREIGN KEY FK_73F50A3740FC9F8A');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1EA5C2B84');
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A8EA5C2B84');
        $this->addSql('ALTER TABLE station_meteos DROP FOREIGN KEY FK_1AB03F12A76ED395');
        $this->addSql('DROP TABLE alert_meteo');
        $this->addSql('DROP TABLE arcticles');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE etat_station_meteo');
        $this->addSql('DROP TABLE mini_maxi');
        $this->addSql('DROP TABLE mini_maxi_a');
        $this->addSql('DROP TABLE mini_maxi_h');
        $this->addSql('DROP TABLE orages');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE station_direct');
        $this->addSql('DROP TABLE station_meteos');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vigilance_meteofrance');
    }
}
