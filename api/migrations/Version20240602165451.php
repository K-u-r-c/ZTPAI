<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602165451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sent_notifications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sent_notifications (id INT NOT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN sent_notifications.sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE sent_notifications_user (sent_notifications_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(sent_notifications_id, user_id))');
        $this->addSql('CREATE INDEX IDX_262B14E6460DB6C3 ON sent_notifications_user (sent_notifications_id)');
        $this->addSql('CREATE INDEX IDX_262B14E6A76ED395 ON sent_notifications_user (user_id)');
        $this->addSql('CREATE TABLE sent_notifications_notification (sent_notifications_id INT NOT NULL, notification_id INT NOT NULL, PRIMARY KEY(sent_notifications_id, notification_id))');
        $this->addSql('CREATE INDEX IDX_66D532D7460DB6C3 ON sent_notifications_notification (sent_notifications_id)');
        $this->addSql('CREATE INDEX IDX_66D532D7EF1A9D84 ON sent_notifications_notification (notification_id)');
        $this->addSql('ALTER TABLE sent_notifications_user ADD CONSTRAINT FK_262B14E6460DB6C3 FOREIGN KEY (sent_notifications_id) REFERENCES sent_notifications (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_notifications_user ADD CONSTRAINT FK_262B14E6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_notifications_notification ADD CONSTRAINT FK_66D532D7460DB6C3 FOREIGN KEY (sent_notifications_id) REFERENCES sent_notifications (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_notifications_notification ADD CONSTRAINT FK_66D532D7EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sent_notifications_id_seq CASCADE');
        $this->addSql('ALTER TABLE sent_notifications_user DROP CONSTRAINT FK_262B14E6460DB6C3');
        $this->addSql('ALTER TABLE sent_notifications_user DROP CONSTRAINT FK_262B14E6A76ED395');
        $this->addSql('ALTER TABLE sent_notifications_notification DROP CONSTRAINT FK_66D532D7460DB6C3');
        $this->addSql('ALTER TABLE sent_notifications_notification DROP CONSTRAINT FK_66D532D7EF1A9D84');
        $this->addSql('DROP TABLE sent_notifications');
        $this->addSql('DROP TABLE sent_notifications_user');
        $this->addSql('DROP TABLE sent_notifications_notification');
    }
}
