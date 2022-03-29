<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329213639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_user_type DROP FOREIGN KEY FK_8975D6B1B88FF97F');
        $this->addSql('DROP INDEX IDX_8975D6B1B88FF97F ON task_user_type');
        $this->addSql('ALTER TABLE task_user_type DROP task_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_user_type ADD task_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_user_type ADD CONSTRAINT FK_8975D6B1B88FF97F FOREIGN KEY (task_user_id) REFERENCES task_user (id)');
        $this->addSql('CREATE INDEX IDX_8975D6B1B88FF97F ON task_user_type (task_user_id)');
    }
}
