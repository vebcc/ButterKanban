<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329213959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_user ADD task_user_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE20423255D0B6B4 FOREIGN KEY (task_user_type_id) REFERENCES task_user_type (id)');
        $this->addSql('CREATE INDEX IDX_FE20423255D0B6B4 ON task_user (task_user_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE20423255D0B6B4');
        $this->addSql('DROP INDEX IDX_FE20423255D0B6B4 ON task_user');
        $this->addSql('ALTER TABLE task_user DROP task_user_type_id');
    }
}
