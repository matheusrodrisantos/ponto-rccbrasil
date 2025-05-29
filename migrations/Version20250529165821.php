<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529165821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data, status FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL, entrada VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , saida VARCHAR(255) NOT NULL, CONSTRAINT FK_2ED7D752642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO registro_ponto (id, funcionario_id, data, entrada) SELECT id, funcionario_id, data, status FROM __temp__registro_ponto
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
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL, hora_entrada DATETIME NOT NULL, hora_saida DATETIME NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_2ED7D752642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO registro_ponto (id, funcionario_id, data) SELECT id, funcionario_id, data FROM __temp__registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2ED7D752642FEB76 ON registro_ponto (funcionario_id)
        SQL);
    }
}
