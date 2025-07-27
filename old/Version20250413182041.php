<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413182041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige les relations entre station et station_meteos, supprime id_station_meteo et ajuste station_id.';
    }

    public function up(Schema $schema): void
    {
        // Supprimez la colonne id_station_meteo si elle existe encore
        $this->addSql('ALTER TABLE station DROP COLUMN id_station_meteo');

        // Assurez-vous que station_id a des valeurs valides
        $this->addSql('UPDATE station SET station_id = (SELECT id FROM station_meteos LIMIT 1) WHERE station_id IS NULL');

        // Vérifiez si la contrainte FK_9F39F8B121BDB235 existe avant de l'ajouter
        $this->addSql("
            SET @constraint_name = (
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_NAME = 'station'
                AND CONSTRAINT_NAME = 'FK_9F39F8B121BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@constraint_name IS NULL, 'ALTER TABLE station ADD CONSTRAINT FK_9F39F8B121BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Vérifiez si l'index UNIQ_9F39F8B121BDB235 existe avant de le recréer
        $this->addSql("
            SET @index_name = (
                SELECT INDEX_NAME
                FROM information_schema.STATISTICS
                WHERE TABLE_NAME = 'station'
                AND INDEX_NAME = 'UNIQ_9F39F8B121BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@index_name IS NULL, 'CREATE UNIQUE INDEX UNIQ_9F39F8B121BDB235 ON station (station_id)', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        $this->addSql('CREATE INDEX IDX_9F39F8B121BDB235 ON station (station_id)');

        // Ajoutez la contrainte de clé étrangère pour station_direct
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');

        // Créez la table de jointure pour la relation ManyToMany
        $this->addSql('CREATE TABLE station_station_meteos (
            station_id INT NOT NULL,
            station_meteos_id INT NOT NULL,
            INDEX IDX_123456789ABCDEF (station_id),
            INDEX IDX_987654321FEDCBA (station_meteos_id),
            PRIMARY KEY(station_id, station_meteos_id)
        )');
        $this->addSql('ALTER TABLE station_station_meteos ADD CONSTRAINT FK_123456789ABCDEF FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station_station_meteos ADD CONSTRAINT FK_987654321FEDCBA FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // Restaurez la colonne id_station_meteo
        $this->addSql('ALTER TABLE station ADD id_station_meteo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1A376CA5B FOREIGN KEY (id_station_meteo) REFERENCES station_meteos (id)');
        $this->addSql('CREATE INDEX IDX_9F39F8B1A376CA5B ON station (id_station_meteo)');

        // Supprimez la contrainte et l'index pour station_id
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX UNIQ_9F39F8B121BDB235 ON station');
        $this->addSql('DROP INDEX IDX_9F39F8B121BDB235 ON station');

        // Supprimez la contrainte pour station_direct
        $this->addSql('ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A821BDB235');
        $this->addSql('DROP INDEX UNIQ_EFF506A821BDB235 ON station_direct');

        // Supprimez la table de jointure
        $this->addSql('DROP TABLE station_station_meteos');
    }
}
