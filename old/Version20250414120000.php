<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-généré Migration: Veuillez modifier selon vos besoins!
 */
final class Version20250414120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige les problèmes liés à station_id et assure que toutes les données sont valides.';
    }

    public function up(Schema $schema): void
    {
        // Vérifiez si la colonne station_id existe avant de l'ajouter
        $this->addSql("
            SET @column_exists = (
                SELECT COUNT(*)
                FROM information_schema.COLUMNS
                WHERE TABLE_NAME = 'station'
                AND COLUMN_NAME = 'station_id'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@column_exists = 0, 'ALTER TABLE station ADD station_id INT DEFAULT NULL', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Assurez-vous que station_id a des valeurs valides
        $this->addSql('UPDATE station SET station_id = (SELECT id FROM station_meteos ORDER BY id ASC LIMIT 1) WHERE station_id IS NULL');

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

        // Ajoutez la contrainte de clé étrangère pour station_direct
        $this->addSql("
            SET @column_exists = (
                SELECT COUNT(*)
                FROM information_schema.COLUMNS
                WHERE TABLE_NAME = 'station_direct'
                AND COLUMN_NAME = 'station_id'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@column_exists = 0, 'ALTER TABLE station_direct ADD station_id INT DEFAULT NULL', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Vérifiez si la contrainte FK_EFF506A821BDB235 existe avant de l'ajouter
        $this->addSql("
            SET @constraint_name = (
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_NAME = 'station_direct'
                AND CONSTRAINT_NAME = 'FK_EFF506A821BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@constraint_name IS NULL, 'ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Supprimez l'index s'il existe, puis recréez-le
        $this->addSql("
            SET @index_name = (
                SELECT INDEX_NAME
                FROM information_schema.STATISTICS
                WHERE TABLE_NAME = 'station_direct'
                AND INDEX_NAME = 'UNIQ_EFF506A821BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@index_name IS NOT NULL, CONCAT('DROP INDEX ', @index_name, ' ON station_direct'), 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');

        // Supprimez la contrainte OneToOne existante
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX UNIQ_9F39F8B121BDB235 ON station');

        // Ajoutez la nouvelle relation ManyToOne
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B121BDB235 FOREIGN KEY (stationMeteos_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE INDEX IDX_9F39F8B121BDB235 ON station (stationMeteos_id)');

        // Ajoutez la colonne station_meteos_id si elle n'existe pas
        $this->addSql("
            SET @column_exists = (
                SELECT COUNT(*)
                FROM information_schema.COLUMNS
                WHERE TABLE_NAME = 'station'
                AND COLUMN_NAME = 'station_meteos_id'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@column_exists = 0, 'ALTER TABLE station ADD station_meteos_id INT DEFAULT NULL', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Ajoutez la contrainte de clé étrangère pour station_meteos_id
        $this->addSql("
            SET @constraint_name = (
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_NAME = 'station'
                AND CONSTRAINT_NAME = 'FK_9F39F8B121BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@constraint_name IS NULL, 'ALTER TABLE station ADD CONSTRAINT FK_9F39F8B121BDB235 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id)', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Vérifiez et corrigez les références à station_meteo_2.station_station_meteos
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
        // Vérifiez si la contrainte FK_EFF506A821BDB235 existe avant de la supprimer
        $this->addSql("
            SET @constraint_name = (
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_NAME = 'station_direct'
                AND CONSTRAINT_NAME = 'FK_EFF506A821BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@constraint_name IS NOT NULL, 'ALTER TABLE station_direct DROP FOREIGN KEY FK_EFF506A821BDB235', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Supprimez l'index s'il existe
        $this->addSql("
            SET @index_name = (
                SELECT INDEX_NAME
                FROM information_schema.STATISTICS
                WHERE TABLE_NAME = 'station_direct'
                AND INDEX_NAME = 'UNIQ_EFF506A821BDB235'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@index_name IS NOT NULL, CONCAT('DROP INDEX ', @index_name, ' ON station_direct'), 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Supprimez la colonne station_id si elle existe
        $this->addSql("
            SET @column_exists = (
                SELECT COUNT(*)
                FROM information_schema.COLUMNS
                WHERE TABLE_NAME = 'station_direct'
                AND COLUMN_NAME = 'station_id'
                AND TABLE_SCHEMA = DATABASE()
            );
            SET @sql = IF(@column_exists > 0, 'ALTER TABLE station_direct DROP COLUMN station_id', 'SELECT 1');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        ");

        // Supprimez les contraintes et index ajoutés
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX UNIQ_9F39F8B121BDB235 ON station');
        $this->addSql('ALTER TABLE station DROP COLUMN station_id');

        // Restaurez la relation OneToOne
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX IDX_9F39F8B121BDB235 ON station');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B121BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F39F8B121BDB235 ON station (station_id)');

        // Supprimez la colonne station_meteos_id
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B121BDB235');
        $this->addSql('DROP INDEX IDX_9F39F8B121BDB235 ON station');
        $this->addSql('ALTER TABLE station DROP COLUMN station_meteos_id');

        // Supprimez la table station_station_meteos si elle existe
        $this->addSql('DROP TABLE station_station_meteos');
    }
}
