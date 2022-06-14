<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614131329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pull_request ADD COLUMN state VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pull_request AS SELECT id, name, pre_submit, open, merged, closed, locked FROM pull_request');
        $this->addSql('DROP TABLE pull_request');
        $this->addSql('CREATE TABLE pull_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, pre_submit BOOLEAN NOT NULL, open BOOLEAN NOT NULL, merged BOOLEAN NOT NULL, closed BOOLEAN NOT NULL, locked BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO pull_request (id, name, pre_submit, open, merged, closed, locked) SELECT id, name, pre_submit, open, merged, closed, locked FROM __temp__pull_request');
        $this->addSql('DROP TABLE __temp__pull_request');
    }
}
