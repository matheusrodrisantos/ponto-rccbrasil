<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526115948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE funcionario ADD COLUMN funcao VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__funcionario AS SELECT id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, jornada_diaria, jornada_semanal FROM funcionario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE funcionario
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departamento_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, verificar_localizacao BOOLEAN NOT NULL, ativo BOOLEAN NOT NULL, cpf VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, jornada_diaria INTEGER NOT NULL, jornada_semanal INTEGER NOT NULL, CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO funcionario (id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, jornada_diaria, jornada_semanal) SELECT id, departamento_id, nome, regime, verificar_localizacao, ativo, cpf, email, jornada_diaria, jornada_semanal FROM __temp__funcionario
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
