<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208184642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A8CC52C971');
        $this->addSql('DROP INDEX UNIQ_EFF506A8CC52C971 ON station_direct');
        $this->addSql('ALTER TABLE station_direct CHANGE stationid_id station_id INT NOT NULL');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A821BDB235');
        $this->addSql('DROP INDEX UNIQ_EFF506A821BDB235 ON station_direct');
        $this->addSql('ALTER TABLE station_direct CHANGE station_id stationid_id INT NOT NULL');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A8CC52C971 FOREIGN KEY (stationid_id) REFERENCES station_meteos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A8CC52C971 ON station_direct (stationid_id)');
    }
}
