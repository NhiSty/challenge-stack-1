<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218220631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE agenda_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE appointment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE clinic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE consultation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE demand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_storage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drug_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE necessary_document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE speciality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agenda (id INT NOT NULL, owner_id INT NOT NULL, availability JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CEDC8777E3C61F9 ON agenda (owner_id)');
        $this->addSql('CREATE TABLE appointment (id INT NOT NULL, drug_id_id INT DEFAULT NULL, consultation_id_id INT NOT NULL, date DATE NOT NULL, patient_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE38F844BCC19D8 ON appointment (drug_id_id)');
        $this->addSql('CREATE INDEX IDX_FE38F8444DE7C79 ON appointment (consultation_id_id)');
        $this->addSql('CREATE TABLE appointment_user (appointment_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(appointment_id, user_id))');
        $this->addSql('CREATE INDEX IDX_9E501E88E5B533F9 ON appointment_user (appointment_id)');
        $this->addSql('CREATE INDEX IDX_9E501E88A76ED395 ON appointment_user (user_id)');
        $this->addSql('CREATE TABLE clinic (id INT NOT NULL, name VARCHAR(100) NOT NULL, country VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE consultation (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE demand (id INT NOT NULL, applicant_id INT NOT NULL, state BOOLEAN NOT NULL, file_names JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_428D797397139001 ON demand (applicant_id)');
        $this->addSql('CREATE TABLE demand_necessary_document (demand_id INT NOT NULL, necessary_document_id INT NOT NULL, PRIMARY KEY(demand_id, necessary_document_id))');
        $this->addSql('CREATE INDEX IDX_AA2A03F75D022E59 ON demand_necessary_document (demand_id)');
        $this->addSql('CREATE INDEX IDX_AA2A03F7D4F53507 ON demand_necessary_document (necessary_document_id)');
        $this->addSql('CREATE TABLE document_storage (id INT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(100) DEFAULT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F015BDE89D86650F ON document_storage (user_id_id)');
        $this->addSql('CREATE TABLE drug (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, price INT NOT NULL, stock INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE necessary_document (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE speciality (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, clinic_id INT DEFAULT NULL, speciality_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, gender VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649CC22AD4 ON "user" (clinic_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493B5A08D7 ON "user" (speciality_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC8777E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844BCC19D8 FOREIGN KEY (drug_id_id) REFERENCES drug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8444DE7C79 FOREIGN KEY (consultation_id_id) REFERENCES consultation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment_user ADD CONSTRAINT FK_9E501E88E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment_user ADD CONSTRAINT FK_9E501E88A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D797397139001 FOREIGN KEY (applicant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demand_necessary_document ADD CONSTRAINT FK_AA2A03F75D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demand_necessary_document ADD CONSTRAINT FK_AA2A03F7D4F53507 FOREIGN KEY (necessary_document_id) REFERENCES necessary_document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_storage ADD CONSTRAINT FK_F015BDE89D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6493B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE agenda_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE appointment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE clinic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE consultation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE demand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_storage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drug_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE necessary_document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE speciality_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE agenda DROP CONSTRAINT FK_2CEDC8777E3C61F9');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F844BCC19D8');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F8444DE7C79');
        $this->addSql('ALTER TABLE appointment_user DROP CONSTRAINT FK_9E501E88E5B533F9');
        $this->addSql('ALTER TABLE appointment_user DROP CONSTRAINT FK_9E501E88A76ED395');
        $this->addSql('ALTER TABLE demand DROP CONSTRAINT FK_428D797397139001');
        $this->addSql('ALTER TABLE demand_necessary_document DROP CONSTRAINT FK_AA2A03F75D022E59');
        $this->addSql('ALTER TABLE demand_necessary_document DROP CONSTRAINT FK_AA2A03F7D4F53507');
        $this->addSql('ALTER TABLE document_storage DROP CONSTRAINT FK_F015BDE89D86650F');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CC22AD4');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6493B5A08D7');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE appointment_user');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE demand_necessary_document');
        $this->addSql('DROP TABLE document_storage');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE necessary_document');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
