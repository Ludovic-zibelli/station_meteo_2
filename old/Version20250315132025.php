<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315132025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vigilance_meteofrance ADD text21 LONGTEXT DEFAULT NULL, ADD text22 LONGTEXT DEFAULT NULL, ADD text23 LONGTEXT DEFAULT NULL, ADD text24 LONGTEXT DEFAULT NULL, ADD text25 LONGTEXT DEFAULT NULL, ADD text26 LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vigilance_meteofrance DROP text21, DROP text22, DROP text23, DROP text24, DROP text25, DROP text26');
    }
}
