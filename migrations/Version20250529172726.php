<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration modifiée : ne modifie que la table orages.
 */
final class Version20250529172726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification de la table orages uniquement';
    }

    public function up(Schema $schema): void
    {
        // Modification uniquement de la table orages
        $this->addSql('ALTER TABLE orages ADD radius INT NOT NULL, ADD status VARCHAR(20) NOT NULL, ADD start_time INT NOT NULL, ADD end_time INT NOT NULL, ADD lat DOUBLE PRECISION NOT NULL, ADD lon DOUBLE PRECISION NOT NULL, ADD duration INT NOT NULL, ADD intervals JSON NOT NULL, ADD total_strikes INT NOT NULL, ADD bearings JSON NOT NULL, ADD closests JSON NOT NULL, ADD by_intervals JSON NOT NULL, DROP eclaires_1_km, DROP eclaire_10_km, DROP eclaires_50_km');
    }

    public function down(Schema $schema): void
    {
        // Annulation uniquement sur la table orages
        $this->addSql('ALTER TABLE orages ADD eclaires_1_km INT DEFAULT NULL, ADD eclaire_10_km INT DEFAULT NULL, ADD eclaires_50_km INT DEFAULT NULL, DROP radius, DROP status, DROP start_time, DROP end_time, DROP lat, DROP lon, DROP duration, DROP intervals, DROP total_strikes, DROP bearings, DROP closests, DROP by_intervals');
    }
}
