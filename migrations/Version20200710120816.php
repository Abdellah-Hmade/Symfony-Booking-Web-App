<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200710120816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anonce ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE anonce ADD CONSTRAINT FK_66C18BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_66C18BC60BB6FE6 ON anonce (auteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anonce DROP FOREIGN KEY FK_66C18BC60BB6FE6');
        $this->addSql('DROP INDEX IDX_66C18BC60BB6FE6 ON anonce');
        $this->addSql('ALTER TABLE anonce DROP auteur_id');
    }
}
