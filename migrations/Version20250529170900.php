<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529170900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data, entrada, created_at, updated_at, saida FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL, entrada TIME NOT NULL --(DC2Type:time_immutable)
            , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , saida TIME NOT NULL --(DC2Type:time_immutable)
            , CONSTRAINT FK_2ED7D752642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO registro_ponto (id, funcionario_id, data, entrada, created_at, updated_at, saida) SELECT id, funcionario_id, data, entrada, created_at, updated_at, saida FROM __temp__registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2ED7D752642FEB76 ON registro_ponto (funcionario_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data, created_at, updated_at, entrada, saida FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , entrada VARCHAR(255) NOT NULL, saida VARCHAR(255) NOT NULL, CONSTRAINT FK_2ED7D752642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO registro_ponto (id, funcionario_id, data, created_at, updated_at, entrada, saida) SELECT id, funcionario_id, data, created_at, updated_at, entrada, saida FROM __temp__registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2ED7D752642FEB76 ON registro_ponto (funcionario_id)
        SQL);
    }
}
