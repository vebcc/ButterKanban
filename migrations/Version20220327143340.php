<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327143340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD queue_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25477B5BAE FOREIGN KEY (queue_id) REFERENCES task_queue (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25477B5BAE ON task (queue_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25477B5BAE');
        $this->addSql('DROP INDEX IDX_527EDB25477B5BAE ON task');
        $this->addSql('ALTER TABLE task DROP queue_id');
    }
}
