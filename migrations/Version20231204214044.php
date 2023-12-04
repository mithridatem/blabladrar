<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204214044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `add` (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, localisation_id_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, creation_date DATETIME NOT NULL, description LONGTEXT NOT NULL, place_number INT DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_FD1A73E79D86650F (user_id_id), INDEX IDX_FD1A73E7B65C2D26 (localisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, name_localisation VARCHAR(50) NOT NULL, name_street VARCHAR(50) NOT NULL, num_street INT NOT NULL, town VARCHAR(50) NOT NULL, postal_code INT NOT NULL, lat DOUBLE PRECISION NOT NULL, `long` DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participate (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, add_id_id INT DEFAULT NULL, rdv_date DATETIME NOT NULL, confirm TINYINT(1) NOT NULL, INDEX IDX_D02B1389D86650F (user_id_id), INDEX IDX_D02B138C2F79496 (add_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, activate TINYINT(1) NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `add` ADD CONSTRAINT FK_FD1A73E79D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `add` ADD CONSTRAINT FK_FD1A73E7B65C2D26 FOREIGN KEY (localisation_id_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B1389D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B138C2F79496 FOREIGN KEY (add_id_id) REFERENCES `add` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `add` DROP FOREIGN KEY FK_FD1A73E79D86650F');
        $this->addSql('ALTER TABLE `add` DROP FOREIGN KEY FK_FD1A73E7B65C2D26');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B1389D86650F');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B138C2F79496');
        $this->addSql('DROP TABLE `add`');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE participate');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
