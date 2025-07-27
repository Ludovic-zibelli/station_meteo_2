<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418193347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat_station_meteo CHANGE station_meteo_id station_meteo_id INT NOT NULL');
        $this->addSql('ALTER TABLE etat_station_meteo ADD CONSTRAINT FK_73F50A3740FC9F8A FOREIGN KEY (station_meteo_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');
        $this->addSql('ALTER TABLE station_meteos ADD CONSTRAINT FK_1AB03F12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat_station_meteo DROP FOREIGN KEY FK_73F50A3740FC9F8A');
        $this->addSql('ALTER TABLE etat_station_meteo CHANGE station_meteo_id station_meteo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1EA5C2B84');
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A821BDB235');
        $this->addSql('DROP INDEX UNIQ_EFF506A821BDB235 ON station_direct');
        $this->addSql('ALTER TABLE station_meteos DROP FOREIGN KEY FK_1AB03F12A76ED395');
    }
}
