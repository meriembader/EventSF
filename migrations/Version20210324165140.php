<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324165140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY fk_userEvent');
        $this->addSql('DROP INDEX fk_userEvent ON event');
        $this->addSql('ALTER TABLE event ADD id_user_id INT DEFAULT NULL, DROP id_user');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA779F37AE5 ON event (id_user_id)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY fk_userFormation');
        $this->addSql('DROP INDEX fk_userFormation ON formation');
        $this->addSql('ALTER TABLE formation ADD id_user_id INT DEFAULT NULL, DROP id_user');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_404021BF79F37AE5 ON formation (id_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA779F37AE5');
        $this->addSql('DROP INDEX IDX_3BAE0AA779F37AE5 ON event');
        $this->addSql('ALTER TABLE event ADD id_user INT NOT NULL, DROP id_user_id');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_userEvent FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX fk_userEvent ON event (id_user)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF79F37AE5');
        $this->addSql('DROP INDEX IDX_404021BF79F37AE5 ON formation');
        $this->addSql('ALTER TABLE formation ADD id_user INT NOT NULL, DROP id_user_id');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT fk_userFormation FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX fk_userFormation ON formation (id_user)');
    }
}
