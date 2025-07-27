<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713185926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE site_config (id INT AUTO_INCREMENT NOT NULL, maintenance TINYINT(1) NOT NULL, date_time_main DATETIME NOT NULL, view_station TINYINT(1) NOT NULL, date_time_view DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mini_maxi ADD CONSTRAINT FK_99615C36EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE INDEX IDX_99615C36EA5C2B84 ON mini_maxi (station_meteos_id)');
        $this->addSql('ALTER TABLE mini_maxi_a ADD CONSTRAINT FK_AD8E1761EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE INDEX IDX_AD8E1761EA5C2B84 ON mini_maxi_a (station_meteos_id)');
        $this->addSql('ALTER TABLE mini_maxi_h ADD CONSTRAINT FK_D452AFC5EA5C2B84 FOREIGN KEY (station_meteos_id) REFERENCES station_meteos (id)');
        $this->addSql('CREATE INDEX IDX_D452AFC5EA5C2B84 ON mini_maxi_h (station_meteos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE site_config');
        $this->addSql('ALTER TABLE mini_maxi DROP FOREIGN KEY FK_99615C36EA5C2B84');
        $this->addSql('DROP INDEX IDX_99615C36EA5C2B84 ON mini_maxi');
        $this->addSql('ALTER TABLE mini_maxi_a DROP FOREIGN KEY FK_AD8E1761EA5C2B84');
        $this->addSql('DROP INDEX IDX_AD8E1761EA5C2B84 ON mini_maxi_a');
        $this->addSql('ALTER TABLE mini_maxi_h DROP FOREIGN KEY FK_D452AFC5EA5C2B84');
        $this->addSql('DROP INDEX IDX_D452AFC5EA5C2B84 ON mini_maxi_h');
    }
}
