<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127180412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vigilance_meteofrance (id INT AUTO_INCREMENT NOT NULL, domaine_id INT NOT NULL, domaine_name VARCHAR(255) NOT NULL, bloc_title LONGTEXT NOT NULL, bloc_id LONGTEXT NOT NULL, term_names VARCHAR(255) DEFAULT NULL, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, risk_name VARCHAR(255) DEFAULT NULL, risk_code INT DEFAULT NULL, risk_color VARCHAR(255) DEFAULT NULL, risk_level INT DEFAULT NULL, text_1 LONGTEXT DEFAULT NULL, text_2 LONGTEXT DEFAULT NULL, bold_text_1 VARCHAR(255) DEFAULT NULL, bold_text_2 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vigilance_meteofrance');
    }
}
