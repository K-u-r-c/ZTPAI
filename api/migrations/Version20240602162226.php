<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602162226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sent_notifications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sent_notifications (id INT NOT NULL, sent_to_user_id INT DEFAULT NULL, what_notification_id INT DEFAULT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_48B6703C3AEF91E7 ON sent_notifications (sent_to_user_id)');
        $this->addSql('CREATE INDEX IDX_48B6703C222147AF ON sent_notifications (what_notification_id)');
        $this->addSql('COMMENT ON COLUMN sent_notifications.sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE sent_notifications ADD CONSTRAINT FK_48B6703C3AEF91E7 FOREIGN KEY (sent_to_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_notifications ADD CONSTRAINT FK_48B6703C222147AF FOREIGN KEY (what_notification_id) REFERENCES notification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sent_notifications_id_seq CASCADE');
        $this->addSql('ALTER TABLE sent_notifications DROP CONSTRAINT FK_48B6703C3AEF91E7');
        $this->addSql('ALTER TABLE sent_notifications DROP CONSTRAINT FK_48B6703C222147AF');
        $this->addSql('DROP TABLE sent_notifications');
    }
}
