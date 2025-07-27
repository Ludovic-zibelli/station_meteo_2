<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417191520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE INDEX IDX_9F39F8B1EA5C2B84 ON station (station_meteos_id)');
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A821BDB235');
        $this->addSql('DROP INDEX UNIQ_EFF506A821BDB235 ON station_direct');
        $this->addSql('ALTER TABLE station_direct ADD station_meteos_id INT NOT NULL');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A8EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EFF506A8EA5C2B84 ON station_direct (station_meteos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1EA5C2B84');
        $this->addSql('DROP INDEX IDX_9F39F8B1EA5C2B84 ON station');
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A8EA5C2B84');
        $this->addSql('DROP INDEX IDX_EFF506A8EA5C2B84 ON station_direct');
        $this->addSql('ALTER TABLE station_direct DROP station_meteos_id');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');
    }
}
