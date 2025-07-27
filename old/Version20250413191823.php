<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413191823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Supprimez la clé étrangère et la colonne station_id si elles existent
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX UNIQ_9F39F8B121BDB235 ON station');
        $this->addSql('ALTER TABLE station DROP station_id');
    }

    public function down(Schema $schema): void
    {
        // Restaurez la clé étrangère et la colonne station_id
        $this->addSql('ALTER TABLE station ADD station_id INT NOT NULL');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B121BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F39F8B121BDB235 ON station (station_id)');
    }
}
