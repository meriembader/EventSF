<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324215701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY fk_evenementUser');
        $this->addSql('DROP INDEX fk_evenementUser ON evenement');
        $this->addSql('ALTER TABLE evenement CHANGE debut debut DATETIME NOT NULL, CHANGE fin fin DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement CHANGE debut debut DATE NOT NULL, CHANGE fin fin DATE NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_evenementUser FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX fk_evenementUser ON evenement (id_user)');
    }
}
