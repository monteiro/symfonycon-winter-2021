<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114170625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id VARCHAR(32) NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE car_match (id VARCHAR(32) NOT NULL, reservation_id VARCHAR(32) DEFAULT NULL, car_id VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A5F040D2B83297E7 ON car_match (reservation_id)');
        $this->addSql('CREATE INDEX IDX_A5F040D2C3C6F69F ON car_match (car_id)');
        $this->addSql('CREATE TABLE customer (id VARCHAR(32) NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reservation (id VARCHAR(32) NOT NULL, customer_id VARCHAR(32) DEFAULT NULL, location VARCHAR(255) NOT NULL, pick_up_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , return_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , category VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C849559395C3F3 ON reservation (customer_id)');
        $this->addSql('CREATE TABLE stored_event (id VARCHAR(32) NOT NULL, type_name VARCHAR(255) NOT NULL, event_body VARCHAR(255) NOT NULL, aggregate_root_id VARCHAR(255) NOT NULL, actor_id VARCHAR(32) NOT NULL, published BOOLEAN NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_match');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE stored_event');
    }
}
