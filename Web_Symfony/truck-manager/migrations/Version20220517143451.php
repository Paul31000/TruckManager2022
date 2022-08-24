<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517143451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE history_position (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, en_panne TINYINT(1) NOT NULL, en_pause TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_history (id INT AUTO_INCREMENT NOT NULL, camion_id INT DEFAULT NULL, chauffeur_id INT DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, en_panne TINYINT(1) DEFAULT NULL, en_pause TINYINT(1) DEFAULT NULL, arrive TINYINT(1) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_B44B61B83A706D3 (camion_id), INDEX IDX_B44B61B885C0B3BE (chauffeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE position_history ADD CONSTRAINT FK_B44B61B83A706D3 FOREIGN KEY (camion_id) REFERENCES camion (id)');
        $this->addSql('ALTER TABLE position_history ADD CONSTRAINT FK_B44B61B885C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE history_position');
        $this->addSql('DROP TABLE position_history');
    }
}
