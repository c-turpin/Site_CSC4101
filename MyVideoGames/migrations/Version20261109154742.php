<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261109154742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__showcase AS SELECT id, description, publiee FROM showcase');
        $this->addSql('DROP TABLE showcase');
        $this->addSql('CREATE TABLE showcase (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description VARCHAR(255) NOT NULL, publiee BOOLEAN NOT NULL, membre_id INTEGER NOT NULL, CONSTRAINT FK_14B88CD06A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO showcase (id, description, publiee) SELECT id, description, publiee FROM __temp__showcase');
        $this->addSql('DROP TABLE __temp__showcase');
        $this->addSql('CREATE INDEX IDX_14B88CD06A99F74A ON showcase (membre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__showcase AS SELECT id, description, publiee FROM showcase');
        $this->addSql('DROP TABLE showcase');
        $this->addSql('CREATE TABLE showcase (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description VARCHAR(255) NOT NULL, publiee BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO showcase (id, description, publiee) SELECT id, description, publiee FROM __temp__showcase');
        $this->addSql('DROP TABLE __temp__showcase');
    }
}
