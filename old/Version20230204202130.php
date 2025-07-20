<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204202130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('ALTER TABLE station_direct ADD eclaire1km INT NOT NULL, ADD eclaire10km INT NOT NULL, ADD eclaire50km INT NOT NULL, ADD alertemeteofrance VARCHAR(255) DEFAULT NULL, ADD couleurmeteofrance VARCHAR(255) NOT NULL, ADD datedebutmeteofrance DATETIME DEFAULT NULL, ADD datefinmeteofrance DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE station_direct DROP eclaire1km, DROP eclaire10km, DROP eclaire50km, DROP alertemeteofrance, DROP couleurmeteofrance, DROP datedebutmeteofrance, DROP datefinmeteofrance');
    }
}
