<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327071019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, task_group_id INT NOT NULL, tittle VARCHAR(200) NOT NULL, comment LONGTEXT NOT NULL, start_data DATETIME NOT NULL, INDEX IDX_527EDB25BE94330B (task_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_comment (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, user_id INT NOT NULL, comment LONGTEXT NOT NULL, date DATETIME NOT NULL, type SMALLINT NOT NULL, INDEX IDX_8B9578868DB60186 (task_id), INDEX IDX_8B957886A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_user (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_FE2042328DB60186 (task_id), INDEX IDX_FE204232A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_user_type (id INT AUTO_INCREMENT NOT NULL, task_user_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_8975D6B1B88FF97F (task_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_group_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6491ED93D47 (user_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25BE94330B FOREIGN KEY (task_group_id) REFERENCES task_group (id)');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B9578868DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B957886A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE2042328DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE204232A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task_user_type ADD CONSTRAINT FK_8975D6B1B88FF97F FOREIGN KEY (task_user_id) REFERENCES task_user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_comment DROP FOREIGN KEY FK_8B9578868DB60186');
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE2042328DB60186');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25BE94330B');
        $this->addSql('ALTER TABLE task_user_type DROP FOREIGN KEY FK_8975D6B1B88FF97F');
        $this->addSql('ALTER TABLE task_comment DROP FOREIGN KEY FK_8B957886A76ED395');
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE204232A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491ED93D47');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_comment');
        $this->addSql('DROP TABLE task_group');
        $this->addSql('DROP TABLE task_user');
        $this->addSql('DROP TABLE task_user_type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
