<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407171619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE station_meteos (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_creation DATETIME NOT NULL, ville VARCHAR(255) NOT NULL, codepostal INT NOT NULL, gps_latitude DOUBLE PRECISION DEFAULT NULL, gps_longitude DOUBLE PRECISION DEFAULT NULL, lien_photo LONGTEXT DEFAULT NULL, lien_donnees LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, diy TINYINT(1) DEFAULT NULL, INDEX IDX_1AB03F12A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE station_meteos ADD CONSTRAINT FK_1AB03F12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE station_meteos');
    }
}
