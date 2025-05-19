<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519190543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE departamento (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, supervisor_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, ativo BOOLEAN NOT NULL, CONSTRAINT FK_40E497EB19E9AC5F FOREIGN KEY (supervisor_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_40E497EB19E9AC5F ON departamento (supervisor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ferias (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER DEFAULT NULL, user_inclusao_id INTEGER DEFAULT NULL, ferias_id INTEGER NOT NULL, data_ini DATE NOT NULL, data_fim DATE NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_D675701642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D675701A970C9FB FOREIGN KEY (user_inclusao_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D675701642FEB76 ON ferias (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D675701A970C9FB ON ferias (user_inclusao_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, jornada_diaria TIME NOT NULL, jornada_semanal TIME NOT NULL, CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7510A3CF5A91C08D ON funcionario (departamento_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_FUNCIONARIO_CPF ON funcionario (cpf)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, hora_entrada DATETIME NOT NULL, hora_saida DATETIME NOT NULL, data DATE NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_2ED7D752642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2ED7D752642FEB76 ON registro_ponto (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saldo_horas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario_id INTEGER NOT NULL, horas_trabalhadas TIME DEFAULT NULL, saldo TIME DEFAULT NULL, data DATE NOT NULL, CONSTRAINT FK_742AAD08642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_742AAD08642FEB76 ON saldo_horas (funcionario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE departamento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ferias
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE registro_ponto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saldo_horas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
