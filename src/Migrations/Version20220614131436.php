<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614131436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pull_request AS SELECT id, name, state FROM pull_request');
        $this->addSql('DROP TABLE pull_request');
        $this->addSql('CREATE TABLE pull_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO pull_request (id, name, state) SELECT id, name, state FROM __temp__pull_request');
        $this->addSql('DROP TABLE __temp__pull_request');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pull_request ADD COLUMN pre_submit BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE pull_request ADD COLUMN open BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE pull_request ADD COLUMN merged BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE pull_request ADD COLUMN closed BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE pull_request ADD COLUMN locked BOOLEAN NOT NULL');
    }
}
