<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520193501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870F8EB576A8');
        $this->addSql('DROP INDEX IDX_38D1870F8EB576A8 ON enchere');
        $this->addSql('ALTER TABLE enchere CHANGE id_acheteur_id id_utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870FC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_38D1870FC6EE5C49 ON enchere (id_utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870FC6EE5C49');
        $this->addSql('DROP INDEX IDX_38D1870FC6EE5C49 ON enchere');
        $this->addSql('ALTER TABLE enchere CHANGE id_utilisateur_id id_acheteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F8EB576A8 FOREIGN KEY (id_acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('CREATE INDEX IDX_38D1870F8EB576A8 ON enchere (id_acheteur_id)');
    }
}
