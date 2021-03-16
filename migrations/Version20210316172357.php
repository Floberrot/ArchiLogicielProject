<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316172357 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE motorcycle (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, accessories TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_21E380E1545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE motorcycle ADD CONSTRAINT FK_21E380E1545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE utility_vehicle ADD label VARCHAR(255) NOT NULL, ADD brand VARCHAR(255) NOT NULL, ADD conception_date DATETIME NOT NULL, ADD last_control DATETIME NOT NULL, ADD fuel VARCHAR(255) NOT NULL, ADD licence VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE motorcycle');
        $this->addSql('ALTER TABLE utility_vehicle DROP label, DROP brand, DROP conception_date, DROP last_control, DROP fuel, DROP licence');
    }
}
