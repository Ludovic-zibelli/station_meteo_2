<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418191539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vigilance_meteofrance (id INT AUTO_INCREMENT NOT NULL, domaine_id INT NOT NULL, domaine_name VARCHAR(255) NOT NULL, bloc_title LONGTEXT NOT NULL, bloc_id LONGTEXT NOT NULL, term_names VARCHAR(255) DEFAULT NULL, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, risk_name VARCHAR(255) DEFAULT NULL, risk_code INT DEFAULT NULL, risk_color VARCHAR(255) DEFAULT NULL, risk_level INT DEFAULT NULL, text_1 LONGTEXT DEFAULT NULL, text_2 LONGTEXT DEFAULT NULL, bold_text_1 VARCHAR(255) DEFAULT NULL, bold_text_2 VARCHAR(255) DEFAULT NULL, text_3 LONGTEXT DEFAULT NULL, text_4 LONGTEXT DEFAULT NULL, text_5 LONGTEXT DEFAULT NULL, text_6 LONGTEXT DEFAULT NULL, update_date DATETIME NOT NULL, hazard_code INT DEFAULT NULL, text21 LONGTEXT DEFAULT NULL, text22 LONGTEXT DEFAULT NULL, text23 LONGTEXT DEFAULT NULL, text24 LONGTEXT DEFAULT NULL, text25 LONGTEXT DEFAULT NULL, text26 LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C44267E934 FOREIGN KEY (arcticles_id) REFERENCES arcticles (id)');
        $this->addSql('ALTER TABLE etat_station_meteo CHANGE station_meteo_id station_meteo_id INT NOT NULL');
        $this->addSql('ALTER TABLE etat_station_meteo ADD CONSTRAINT FK_73F50A3740FC9F8A FOREIGN KEY (station_meteo_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station_direct ADD station_meteos_id INT NOT NULL');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A8EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A8EA5C2B84 ON station_direct (station_meteos_id)');
        $this->addSql('ALTER TABLE station_meteos ADD CONSTRAINT FK_1AB03F12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vigilance_meteofrance');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C44267E934');
        $this->addSql('ALTER TABLE etat_station_meteo DROP FOREIGN KEY FK_73F50A3740FC9F8A');
        $this->addSql('ALTER TABLE etat_station_meteo CHANGE station_meteo_id station_meteo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1EA5C2B84');
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A8EA5C2B84');
        $this->addSql('DROP INDEX UNIQ_EFF506A8EA5C2B84 ON station_direct');
        $this->addSql('ALTER TABLE station_direct DROP station_meteos_id');
        $this->addSql('ALTER TABLE station_meteos DROP FOREIGN KEY FK_1AB03F12A76ED395');
    }
}
