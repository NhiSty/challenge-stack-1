<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203114819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE demand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE necessary_document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE demand (id INT NOT NULL, applicant_id INT NOT NULL, state BOOLEAN NOT NULL, file_names TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_428D797397139001 ON demand (applicant_id)');
        $this->addSql('COMMENT ON COLUMN demand.file_names IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE demand_necessary_document (demand_id INT NOT NULL, necessary_document_id INT NOT NULL, PRIMARY KEY(demand_id, necessary_document_id))');
        $this->addSql('CREATE INDEX IDX_AA2A03F75D022E59 ON demand_necessary_document (demand_id)');
        $this->addSql('CREATE INDEX IDX_AA2A03F7D4F53507 ON demand_necessary_document (necessary_document_id)');
        $this->addSql('CREATE TABLE necessary_document (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D797397139001 FOREIGN KEY (applicant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demand_necessary_document ADD CONSTRAINT FK_AA2A03F75D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demand_necessary_document ADD CONSTRAINT FK_AA2A03F7D4F53507 FOREIGN KEY (necessary_document_id) REFERENCES necessary_document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE demand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE necessary_document_id_seq CASCADE');
        $this->addSql('ALTER TABLE demand DROP CONSTRAINT FK_428D797397139001');
        $this->addSql('ALTER TABLE demand_necessary_document DROP CONSTRAINT FK_AA2A03F75D022E59');
        $this->addSql('ALTER TABLE demand_necessary_document DROP CONSTRAINT FK_AA2A03F7D4F53507');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE demand_necessary_document');
        $this->addSql('DROP TABLE necessary_document');
    }
}
