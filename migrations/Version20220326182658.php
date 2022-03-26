<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326182658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_comment ADD task_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B9578868DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B957886A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8B9578868DB60186 ON task_comment (task_id)');
        $this->addSql('CREATE INDEX IDX_8B957886A76ED395 ON task_comment (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_comment DROP FOREIGN KEY FK_8B9578868DB60186');
        $this->addSql('ALTER TABLE task_comment DROP FOREIGN KEY FK_8B957886A76ED395');
        $this->addSql('DROP INDEX IDX_8B9578868DB60186 ON task_comment');
        $this->addSql('DROP INDEX IDX_8B957886A76ED395 ON task_comment');
        $this->addSql('ALTER TABLE task_comment DROP task_id, DROP user_id');
    }
}
