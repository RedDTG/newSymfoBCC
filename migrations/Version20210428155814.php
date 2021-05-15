<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428155814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheteur (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT DEFAULT NULL, is_solvable TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_304AFF9DC6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comissaire_priseur (id INT AUTO_INCREMENT NOT NULL, id_personne_id INT NOT NULL, UNIQUE INDEX UNIQ_5F13AF1BBA091CE5 (id_personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enchere (id INT AUTO_INCREMENT NOT NULL, id_lot_id INT NOT NULL, id_acheteur_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, INDEX IDX_38D1870F8EFC101A (id_lot_id), INDEX IDX_38D1870F8EB576A8 (id_acheteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estimation (id INT AUTO_INCREMENT NOT NULL, id_commissaire_id INT NOT NULL, id_produit_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, date_estimation DATE NOT NULL, INDEX IDX_D0527024CA8C2027 (id_commissaire_id), INDEX IDX_D0527024AABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, id_vente_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, prix_depart DOUBLE PRECISION DEFAULT NULL, is_vendu TINYINT(1) NOT NULL, INDEX IDX_B81291B2D1CFB9F (id_vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, telephone INT DEFAULT NULL, email VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, id_lot_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_29A5EC278EFC101A (id_lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_personne_id INT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, ville VARCHAR(50) DEFAULT NULL, code_postal INT DEFAULT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3BA091CE5 (id_personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendeur (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_7AF49996C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, id_lieu_id INT NOT NULL, type_de_vente VARCHAR(50) DEFAULT NULL, devise VARCHAR(25) DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, heure_debut TIME DEFAULT NULL, heure_fin TIME DEFAULT NULL, INDEX IDX_888A2A4CB42FBABC (id_lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acheteur ADD CONSTRAINT FK_304AFF9DC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE comissaire_priseur ADD CONSTRAINT FK_5F13AF1BBA091CE5 FOREIGN KEY (id_personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F8EFC101A FOREIGN KEY (id_lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F8EB576A8 FOREIGN KEY (id_acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('ALTER TABLE estimation ADD CONSTRAINT FK_D0527024CA8C2027 FOREIGN KEY (id_commissaire_id) REFERENCES comissaire_priseur (id)');
        $this->addSql('ALTER TABLE estimation ADD CONSTRAINT FK_D0527024AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B2D1CFB9F FOREIGN KEY (id_vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC278EFC101A FOREIGN KEY (id_lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BA091CE5 FOREIGN KEY (id_personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE vendeur ADD CONSTRAINT FK_7AF49996C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4CB42FBABC FOREIGN KEY (id_lieu_id) REFERENCES lieu (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870F8EB576A8');
        $this->addSql('ALTER TABLE estimation DROP FOREIGN KEY FK_D0527024CA8C2027');
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4CB42FBABC');
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870F8EFC101A');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC278EFC101A');
        $this->addSql('ALTER TABLE comissaire_priseur DROP FOREIGN KEY FK_5F13AF1BBA091CE5');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BA091CE5');
        $this->addSql('ALTER TABLE estimation DROP FOREIGN KEY FK_D0527024AABEFE2C');
        $this->addSql('ALTER TABLE acheteur DROP FOREIGN KEY FK_304AFF9DC6EE5C49');
        $this->addSql('ALTER TABLE vendeur DROP FOREIGN KEY FK_7AF49996C6EE5C49');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B2D1CFB9F');
        $this->addSql('DROP TABLE acheteur');
        $this->addSql('DROP TABLE comissaire_priseur');
        $this->addSql('DROP TABLE enchere');
        $this->addSql('DROP TABLE estimation');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vendeur');
        $this->addSql('DROP TABLE vente');
    }
}
