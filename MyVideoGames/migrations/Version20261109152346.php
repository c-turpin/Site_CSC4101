<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261109152346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE showcase_jeu (showcase_id INTEGER NOT NULL, jeu_id INTEGER NOT NULL, PRIMARY KEY (showcase_id, jeu_id), CONSTRAINT FK_37323FFFB9441CED FOREIGN KEY (showcase_id) REFERENCES showcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_37323FFF8C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_37323FFFB9441CED ON showcase_jeu (showcase_id)');
        $this->addSql('CREATE INDEX IDX_37323FFF8C9E392E ON showcase_jeu (jeu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE showcase_jeu');
    }
}
