<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429151633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE arcticles (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, titre VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, auteur VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, online TINYINT(1) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_4473CEFA12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, arcticles_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, online TINYINT(1) NOT NULL, signaler TINYINT(1) NOT NULL, INDEX IDX_D9BEC0C44267E934 (arcticles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, date_heure DATETIME NOT NULL, temperature INT NOT NULL, humiditer INT NOT NULL, pression INT NOT NULL, lumiere INT NOT NULL, anemometre INT NOT NULL, girouette INT NOT NULL, pluviometre INT NOT NULL, point_rosee INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arcticles ADD CONSTRAINT FK_4473CEFA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C44267E934 FOREIGN KEY (arcticles_id) REFERENCES arcticles (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C44267E934');
        $this->addSql('ALTER TABLE arcticles DROP FOREIGN KEY FK_4473CEFA12469DE2');
        $this->addSql('DROP TABLE arcticles');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE user');
    }
}
