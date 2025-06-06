<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606181104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__departamento AS SELECT id, supervisor_id, nome, descricao, ativo, created_at, updated_at FROM departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE departamento
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE departamento (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, supervisor_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, ativo BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_40E497EB19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO departamento (id, supervisor_id, nome, descricao, ativo, created_at, updated_at) SELECT id, supervisor_id, nome, descricao, ativo, created_at, updated_at FROM __temp__departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__departamento
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_40E497EB19E9AC5F ON departamento (supervisor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__ferias AS SELECT id, funcionario_id, responsavel_pela_inclusao_id, created_at, updated_at, data_inicio, data_fim FROM ferias
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ferias
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ferias (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, responsavel_pela_inclusao_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , data_inicio DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , data_fim DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_D675701642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D675701FA22BE7D FOREIGN KEY (responsavel_pela_inclusao_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO ferias (id, funcionario_id, responsavel_pela_inclusao_id, created_at, updated_at, data_inicio, data_fim) SELECT id, funcionario_id, responsavel_pela_inclusao_id, created_at, updated_at, data_inicio, data_fim FROM __temp__ferias
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__ferias
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D675701642FEB76 ON ferias (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D675701FA22BE7D ON ferias (responsavel_pela_inclusao_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__funcionario AS SELECT id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, jornada_diaria_segundos, jornada_semanal_segundos, funcao, created_at, updated_at FROM funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, jornada_diaria_segundos INTEGER NOT NULL, jornada_semanal_segundos INTEGER NOT NULL, funcao VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO funcionario (id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, jornada_diaria_segundos, jornada_semanal_segundos, funcao, created_at, updated_at) SELECT id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, jornada_diaria_segundos, jornada_semanal_segundos, funcao, created_at, updated_at FROM __temp__funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_FUNCIONARIO_CPF ON funcionario (cpf)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7510A3CF5A91C08D ON funcionario (departamento_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, funcionario_id, data, entrada, created_at, updated_at, saida FROM registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL --(DC2Type:date_immutable)
            , entrada DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , saida DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
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
            CREATE TEMPORARY TABLE __temp__saldo_horas AS SELECT id, funcionario_id, data, created_at, updated_at, horas_trabalhadas_segundos, saldo_segundos FROM saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saldo_horas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL --(DC2Type:date_immutable)
            , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , horas_trabalhadas_segundos INTEGER NOT NULL, saldo_segundos INTEGER NOT NULL, CONSTRAINT FK_742AAD08642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO saldo_horas (id, funcionario_id, data, created_at, updated_at, horas_trabalhadas_segundos, saldo_segundos) SELECT id, funcionario_id, data, created_at, updated_at, horas_trabalhadas_segundos, saldo_segundos FROM __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_742AAD08642FEB76 ON saldo_horas (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__usuario AS SELECT id, email, roles, password, created_at, updated_at FROM usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO usuario (id, email, roles, password, created_at, updated_at) SELECT id, email, roles, password, created_at, updated_at FROM __temp__usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__usuario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON usuario (email)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__departamento AS SELECT id, supervisor_id, nome, descricao, ativo, created_at, updated_at FROM departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE departamento
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE departamento (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, supervisor_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, ativo BOOLEAN NOT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_40E497EB19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO departamento (id, supervisor_id, nome, descricao, ativo, created_at, updated_at) SELECT id, supervisor_id, nome, descricao, ativo, created_at, updated_at FROM __temp__departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__departamento
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_40E497EB19E9AC5F ON departamento (supervisor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__ferias AS SELECT id, funcionario_id, responsavel_pela_inclusao_id, created_at, updated_at, data_inicio, data_fim FROM ferias
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ferias
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ferias (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, responsavel_pela_inclusao_id INTEGER NOT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , data_inicio DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , data_fim DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_D675701642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D675701FA22BE7D FOREIGN KEY (responsavel_pela_inclusao_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO ferias (id, funcionario_id, responsavel_pela_inclusao_id, created_at, updated_at, data_inicio, data_fim) SELECT id, funcionario_id, responsavel_pela_inclusao_id, created_at, updated_at, data_inicio, data_fim FROM __temp__ferias
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__ferias
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D675701642FEB76 ON ferias (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D675701FA22BE7D ON ferias (responsavel_pela_inclusao_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__funcionario AS SELECT id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, created_at, updated_at, cpf, email, jornada_diaria_segundos, jornada_semanal_segundos FROM funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, funcao VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, jornada_diaria_segundos INTEGER NOT NULL, jornada_semanal_segundos INTEGER NOT NULL, CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO funcionario (id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, created_at, updated_at, cpf, email, jornada_diaria_segundos, jornada_semanal_segundos) SELECT id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, created_at, updated_at, cpf, email, jornada_diaria_segundos, jornada_semanal_segundos FROM __temp__funcionario
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
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL --(DC2Type:date_immutable)
            , created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , entrada TIME DEFAULT NULL --(DC2Type:time_immutable)
            , saida TIME DEFAULT NULL --(DC2Type:time_immutable)
            , CONSTRAINT FK_2ED7D752642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
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
            CREATE TEMPORARY TABLE __temp__saldo_horas AS SELECT id, funcionario_id, data, created_at, updated_at, horas_trabalhadas_segundos, saldo_segundos FROM saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saldo_horas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, data DATE NOT NULL --(DC2Type:date_immutable)
            , created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , horas_trabalhadas_segundos INTEGER NOT NULL, saldo_segundos INTEGER NOT NULL, CONSTRAINT FK_742AAD08642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO saldo_horas (id, funcionario_id, data, created_at, updated_at, horas_trabalhadas_segundos, saldo_segundos) SELECT id, funcionario_id, data, created_at, updated_at, horas_trabalhadas_segundos, saldo_segundos FROM __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_742AAD08642FEB76 ON saldo_horas (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__usuario AS SELECT id, email, roles, password, created_at, updated_at FROM usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO usuario (id, email, roles, password, created_at, updated_at) SELECT id, email, roles, password, created_at, updated_at FROM __temp__usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__usuario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON usuario (email)
        SQL);
    }
}
