<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411214023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reply_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE TABLE notification (id INT NOT NULL, user_id_id INT DEFAULT NULL, message TEXT NOT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, is_read BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF5476CA9D86650F ON notification (user_id_id)');
        $this->addSql('COMMENT ON COLUMN notification.sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, category_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, posted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D9777D11E ON post (category_id_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D9D86650F ON post (user_id_id)');
        $this->addSql('COMMENT ON COLUMN post.posted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reply (id INT NOT NULL, post_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, replied_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDA8C6E0E85F12B8 ON reply (post_id_id)');
        $this->addSql('CREATE INDEX IDX_FDA8C6E09D86650F ON reply (user_id_id)');
        $this->addSql('COMMENT ON COLUMN reply.replied_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE session (id INT NOT NULL, user_id_id INT DEFAULT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, total_time VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D49D86650F ON session (user_id_id)');
        $this->addSql('COMMENT ON COLUMN session.start_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session.end_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session.total_time IS \'(DC2Type:dateinterval)\'');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0E85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E09D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D49D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reply_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE session_id_seq CASCADE');
        $this->addSql('ALTER TABLE notification DROP CONSTRAINT FK_BF5476CA9D86650F');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D9777D11E');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D9D86650F');
        $this->addSql('ALTER TABLE reply DROP CONSTRAINT FK_FDA8C6E0E85F12B8');
        $this->addSql('ALTER TABLE reply DROP CONSTRAINT FK_FDA8C6E09D86650F');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D49D86650F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reply');
        $this->addSql('DROP TABLE session');
        $this->addSql('ALTER TABLE "user" ALTER created_at DROP DEFAULT');
    }
}
