<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516181339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot ADD best_enchere_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BF5A0937F FOREIGN KEY (best_enchere_id) REFERENCES enchere (id)');
        $this->addSql('CREATE INDEX IDX_B81291BF5A0937F ON lot (best_enchere_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BF5A0937F');
        $this->addSql('DROP INDEX IDX_B81291BF5A0937F ON lot');
        $this->addSql('ALTER TABLE lot DROP best_enchere_id');
    }
}
