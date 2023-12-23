<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231223153440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id VARCHAR(36) NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE car_match (id VARCHAR(36) NOT NULL, reservation_id VARCHAR(36) DEFAULT NULL, car_id VARCHAR(36) DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_A5F040D2B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A5F040D2C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A5F040D2B83297E7 ON car_match (reservation_id)');
        $this->addSql('CREATE INDEX IDX_A5F040D2C3C6F69F ON car_match (car_id)');
        $this->addSql('CREATE TABLE customer (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event_store (id BLOB NOT NULL --(DC2Type:uuid)
        , event_name VARCHAR(255) NOT NULL, event_body CLOB NOT NULL --(DC2Type:json)
        , aggregate_root_id VARCHAR(255) NOT NULL, user_id VARCHAR(32) NOT NULL, published BOOLEAN NOT NULL, occurred_on DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BE4CE95B683C6017 ON event_store (published)');
        $this->addSql('CREATE TABLE reservation (id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) DEFAULT NULL, location VARCHAR(255) NOT NULL, pick_up_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , return_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , category VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_42C849559395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_42C849559395C3F3 ON reservation (customer_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_match');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE event_store');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
