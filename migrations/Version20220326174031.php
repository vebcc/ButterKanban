<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326174031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_user (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, INDEX IDX_FE2042328DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_user_type (id INT AUTO_INCREMENT NOT NULL, task_user_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_8975D6B1B88FF97F (task_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE2042328DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task_user_type ADD CONSTRAINT FK_8975D6B1B88FF97F FOREIGN KEY (task_user_id) REFERENCES task_user (id)');
        $this->addSql('ALTER TABLE task ADD task_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25BE94330B FOREIGN KEY (task_group_id) REFERENCES task_group (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25BE94330B ON task (task_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25BE94330B');
        $this->addSql('ALTER TABLE task_user_type DROP FOREIGN KEY FK_8975D6B1B88FF97F');
        $this->addSql('DROP TABLE task_group');
        $this->addSql('DROP TABLE task_user');
        $this->addSql('DROP TABLE task_user_type');
        $this->addSql('DROP INDEX IDX_527EDB25BE94330B ON task');
        $this->addSql('ALTER TABLE task DROP task_group_id');
    }
}
