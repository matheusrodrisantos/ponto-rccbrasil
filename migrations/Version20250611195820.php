<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611195820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE feriado (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, data DATE NOT NULL --(DC2Type:date_immutable)
            , nivel VARCHAR(255) NOT NULL, recorrente BOOLEAN NOT NULL, inicio DATE NOT NULL --(DC2Type:date_immutable)
            , fim DATE NOT NULL --(DC2Type:date_immutable)
            , nome VARCHAR(255) NOT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE feriado
        SQL);
    }
}
