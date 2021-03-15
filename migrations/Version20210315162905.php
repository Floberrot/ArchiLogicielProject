<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315162905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utility_vehicle (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, max_load DOUBLE PRECISION NOT NULL, trunk_capacity DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_372488E2545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, conception_date DATETIME NOT NULL, last_control DATETIME NOT NULL, fuel VARCHAR(255) NOT NULL, licence VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utility_vehicle ADD CONSTRAINT FK_372488E2545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utility_vehicle DROP FOREIGN KEY FK_372488E2545317D1');
        $this->addSql('DROP TABLE utility_vehicle');
        $this->addSql('DROP TABLE vehicle');
    }
}
