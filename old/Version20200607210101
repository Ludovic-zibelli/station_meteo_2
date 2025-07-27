<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200607210101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mini_maxi_h (id INT AUTO_INCREMENT NOT NULL, mini_temp VARCHAR(255) NOT NULL, maxi_temp VARCHAR(255) NOT NULL, mini_humi VARCHAR(255) NOT NULL, maxi_humi VARCHAR(255) NOT NULL, mini_pres VARCHAR(255) NOT NULL, maxi_pres VARCHAR(255) NOT NULL, mini_lumi VARCHAR(255) NOT NULL, mini_ptro VARCHAR(255) NOT NULL, maxi_ptro VARCHAR(255) NOT NULL, mini_anemo VARCHAR(255) NOT NULL, maxi_anemo VARCHAR(255) NOT NULL, mini_girou VARCHAR(255) NOT NULL, maxi_girou VARCHAR(255) NOT NULL, mini_pluvio VARCHAR(255) NOT NULL, maxi_pluvio VARCHAR(255) NOT NULL, maxi_lumi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE mini_maxi_h');
    }
}
