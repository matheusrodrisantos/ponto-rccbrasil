<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529185418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE departamento ADD COLUMN created_at DATETIME NULL  
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE departamento ADD COLUMN updated_at DATETIME NULL 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE funcionario ADD COLUMN created_at DATETIME NULL 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE funcionario ADD COLUMN updated_at DATETIME NULL 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data, entrada, created_at, updated_at, saida FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL, entrada TIME NOT NULL --(DC2Type:time_immutable)
            , created_at DATETIME NULL  --(DC2Type:datetime_immutable)
            , updated_at DATETIME NULL  --(DC2Type:datetime_immutable)
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
        $this->addSql(<<<'SQL'
            ALTER TABLE saldo_horas ADD COLUMN created_at DATETIME NULL 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE saldo_horas ADD COLUMN updated_at DATETIME NULL 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario ADD COLUMN created_at DATETIME NULL 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario ADD COLUMN updated_at DATETIME NULL 
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__departamento AS SELECT id, supervisor_id, nome, descricao, ativo FROM departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE departamento
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE departamento (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, supervisor_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, ativo BOOLEAN NOT NULL, CONSTRAINT FK_40E497EB19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO departamento (id, supervisor_id, nome, descricao, ativo) SELECT id, supervisor_id, nome, descricao, ativo FROM __temp__departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__departamento
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_40E497EB19E9AC5F ON departamento (supervisor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__funcionario AS SELECT id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, cpf, email, jornada_diaria, jornada_semanal FROM funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, funcao VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, jornada_diaria INTEGER NOT NULL, jornada_semanal INTEGER NOT NULL, CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO funcionario (id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, cpf, email, jornada_diaria, jornada_semanal) SELECT id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, cpf, email, jornada_diaria, jornada_semanal FROM __temp__funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7510A3CF5A91C08D ON funcionario (departamento_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_FUNCIONARIO_CPF ON funcionario (cpf)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data, created_at, updated_at, entrada, saida FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL, created_at DATETIME NULL  --(DC2Type:datetime_immutable)
            , updated_at DATETIME NULL  --(DC2Type:datetime_immutable)
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
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__saldo_horas AS SELECT id, funcionario_id, horas_trabalhadas, saldo, data FROM saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saldo_horas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, horas_trabalhadas TIME DEFAULT NULL, saldo TIME DEFAULT NULL, data DATE NOT NULL, CONSTRAINT FK_742AAD08642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO saldo_horas (id, funcionario_id, horas_trabalhadas, saldo, data) SELECT id, funcionario_id, horas_trabalhadas, saldo, data FROM __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_742AAD08642FEB76 ON saldo_horas (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__usuario AS SELECT id, email, roles, password FROM usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO usuario (id, email, roles, password) SELECT id, email, roles, password FROM __temp__usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__usuario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON usuario (email)
        SQL);
    }
}
