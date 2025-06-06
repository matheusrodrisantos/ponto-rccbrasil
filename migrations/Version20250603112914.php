<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603112914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__saldo_horas AS SELECT id, funcionario_id, horas_trabalhadas, saldo, data, created_at, updated_at FROM saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saldo_horas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, horas_trabalhadas TIME DEFAULT NULL --(DC2Type:time_immutable)
            , saldo TIME DEFAULT NULL --(DC2Type:time_immutable)
            , data DATE NOT NULL --(DC2Type:date_immutable)
            , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_742AAD08642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO saldo_horas (id, funcionario_id, horas_trabalhadas, saldo, data, created_at, updated_at) SELECT id, funcionario_id, horas_trabalhadas, saldo, data, created_at, updated_at FROM __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_742AAD08642FEB76 ON saldo_horas (funcionario_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__saldo_horas AS SELECT id, funcionario_id, horas_trabalhadas, saldo, data, created_at, updated_at FROM saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saldo_horas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, horas_trabalhadas TIME DEFAULT NULL, saldo TIME DEFAULT NULL, data DATE NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_742AAD08642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO saldo_horas (id, funcionario_id, horas_trabalhadas, saldo, data, created_at, updated_at) SELECT id, funcionario_id, horas_trabalhadas, saldo, data, created_at, updated_at FROM __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_742AAD08642FEB76 ON saldo_horas (funcionario_id)
        SQL);
    }
}
