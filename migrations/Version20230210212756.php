<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210212756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_f015bde89d86650f');
        $this->addSql('ALTER TABLE document_storage ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE document_storage ALTER description SET NOT NULL');
        $this->addSql('CREATE INDEX IDX_F015BDE89D86650F ON document_storage (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_F015BDE89D86650F');
        $this->addSql('ALTER TABLE document_storage ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE document_storage ALTER description DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_f015bde89d86650f ON document_storage (user_id_id)');
    }
}
