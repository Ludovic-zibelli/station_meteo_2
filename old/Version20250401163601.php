<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401163601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1A376CA5B');
        $this->addSql('DROP INDEX IDX_9F39F8B1A376CA5B ON station');
        $this->addSql('ALTER TABLE station ADD station_id INT NOT NULL, DROP id_station_meteo_id');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B121BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F39F8B121BDB235 ON station (station_id)');
        $this->addSql('ALTER TABLE station_direct ADD station_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX UNIQ_9F39F8B121BDB235 ON station');
        $this->addSql('ALTER TABLE station ADD id_station_meteo_id INT DEFAULT NULL, DROP station_id');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1A376CA5B FOREIGN KEY (id_station_meteo_id) REFERENCES station_meteos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9F39F8B1A376CA5B ON station (id_station_meteo_id)');
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A821BDB235');
        $this->addSql('DROP INDEX UNIQ_EFF506A821BDB235 ON station_direct');
        $this->addSql('ALTER TABLE station_direct DROP station_id');
    }
}
