<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250618122637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__feriado AS SELECT id, nivel, nome, created_at, updated_at FROM feriado
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE feriado
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE feriado (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nivel VARCHAR(255) NOT NULL, nome VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , data_dia INTEGER NOT NULL, data_mes INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO feriado (id, nivel, nome, created_at, updated_at) SELECT id, nivel, nome, created_at, updated_at FROM __temp__feriado
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__feriado
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__feriado AS SELECT id, nivel, nome, created_at, updated_at FROM feriado
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE feriado
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE feriado (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nivel VARCHAR(255) NOT NULL, nome VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , datadia INTEGER NOT NULL, datames INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO feriado (id, nivel, nome, created_at, updated_at) SELECT id, nivel, nome, created_at, updated_at FROM __temp__feriado
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__feriado
        SQL);
    }
}
