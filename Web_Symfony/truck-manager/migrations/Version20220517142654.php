<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517142654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE camion (id INT AUTO_INCREMENT NOT NULL, imatriculation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camionstatus (id INT AUTO_INCREMENT NOT NULL, camion_id INT DEFAULT NULL, chauffeur_id INT DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, en_panne TINYINT(1) DEFAULT NULL, en_pause TINYINT(1) DEFAULT NULL, arrive TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_791AC8403A706D3 (camion_id), UNIQUE INDEX UNIQ_791AC84085C0B3BE (chauffeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE camionstatus ADD CONSTRAINT FK_791AC8403A706D3 FOREIGN KEY (camion_id) REFERENCES camion (id)');
        $this->addSql('ALTER TABLE camionstatus ADD CONSTRAINT FK_791AC84085C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE camionstatus DROP FOREIGN KEY FK_791AC8403A706D3');
        $this->addSql('ALTER TABLE camionstatus DROP FOREIGN KEY FK_791AC84085C0B3BE');
        $this->addSql('DROP TABLE camion');
        $this->addSql('DROP TABLE camionstatus');
        $this->addSql('DROP TABLE chauffeur');
    }
}
