<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413125135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_direct ADD station_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station_direct ADD CONSTRAINT FK_EFF506A821BDB235 FOREIGN KEY (station_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF506A821BDB235 ON station_direct (station_id)');
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
    }
}
