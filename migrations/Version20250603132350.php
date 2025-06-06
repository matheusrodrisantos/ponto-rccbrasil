<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603132350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__funcionario AS SELECT id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, funcao, created_at, updated_at FROM funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, funcao VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , jornada_diaria_segundos INTEGER NOT NULL, jornada_semanal_segundos INTEGER NOT NULL, CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO funcionario (id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, funcao, created_at, updated_at) SELECT id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, funcao, created_at, updated_at FROM __temp__funcionario
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__funcionario AS SELECT id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, created_at, updated_at, cpf, email FROM funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, funcao VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, jornada_diaria INTEGER NOT NULL, jornada_semanal INTEGER NOT NULL, CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO funcionario (id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, created_at, updated_at, cpf, email) SELECT id, departamento_id, nome, regime, funcao, verificar_localizacao, ativo, created_at, updated_at, cpf, email FROM __temp__funcionario
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
    }
}
