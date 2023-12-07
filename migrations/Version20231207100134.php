<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207100134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, localisation_id_id INT DEFAULT NULL, title_event VARCHAR(255) NOT NULL, desc_event LONGTEXT NOT NULL, date_event DATETIME NOT NULL, img_event VARCHAR(255) DEFAULT NULL, INDEX IDX_3BAE0AA7B65C2D26 (localisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B65C2D26 FOREIGN KEY (localisation_id_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE participate ADD message VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD img_users VARCHAR(250) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7B65C2D26');
        $this->addSql('DROP TABLE event');
        $this->addSql('ALTER TABLE participate DROP message');
        $this->addSql('ALTER TABLE `user` DROP img_users');
    }
}
