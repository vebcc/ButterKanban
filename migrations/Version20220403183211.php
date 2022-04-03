<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220403183211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, user_id INT NOT NULL, comment_id INT DEFAULT NULL, old_queue_id INT DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_8F3F68C58DB60186 (task_id), INDEX IDX_8F3F68C5A76ED395 (user_id), INDEX IDX_8F3F68C5F8697D13 (comment_id), INDEX IDX_8F3F68C52C639F83 (old_queue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C58DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5F8697D13 FOREIGN KEY (comment_id) REFERENCES task_comment (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C52C639F83 FOREIGN KEY (old_queue_id) REFERENCES task_queue (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE log');
    }
}
