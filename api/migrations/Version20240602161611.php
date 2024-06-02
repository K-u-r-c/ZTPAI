<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602161611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP CONSTRAINT fk_bf5476ca9d86650f');
        $this->addSql('DROP INDEX idx_bf5476ca9d86650f');
        $this->addSql('ALTER TABLE notification DROP user_id_id');
        $this->addSql('ALTER TABLE notification DROP sent_at');
        $this->addSql('ALTER TABLE notification DROP is_read');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notification ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE notification ADD is_read BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('COMMENT ON COLUMN notification.sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT fk_bf5476ca9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_bf5476ca9d86650f ON notification (user_id_id)');
    }
}
