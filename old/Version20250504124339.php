<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250504124339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
         // Vérifiez si la colonne existe avant de l'ajouter
        $this->addSql("
            DO
            $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'mini_maxi' AND column_name = 'station_meteos_id'
                ) THEN
                    ALTER TABLE mini_maxi ADD station_meteos_id INT NOT NULL;
                    ALTER TABLE mini_maxi ADD CONSTRAINT FK_99615C36EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id);
                    CREATE INDEX IDX_99615C36EA5C2B84 ON mini_maxi (station_meteos_id);
                END IF;
            END
            $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mini_maxi DROP FOREIGN KEY FK_99615C36EA5C2B84');
        $this->addSql('DROP INDEX IDX_99615C36EA5C2B84 ON mini_maxi');
        $this->addSql('ALTER TABLE mini_maxi DROP station_meteos_id');
    }
}
