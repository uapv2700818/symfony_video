<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261003005614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologie ADD COLUMN contenu CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__technologie AS SELECT id, nom, slug, description FROM technologie');
        $this->addSql('DROP TABLE technologie');
        $this->addSql('CREATE TABLE technologie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL)');
        $this->addSql('INSERT INTO technologie (id, nom, slug, description) SELECT id, nom, slug, description FROM __temp__technologie');
        $this->addSql('DROP TABLE __temp__technologie');
    }
}
