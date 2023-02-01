<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201131718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appointment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE clinic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE consultation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_storage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drug_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE speciality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appointment (id INT NOT NULL, drug_id_id INT DEFAULT NULL, consultation_id_id INT NOT NULL, date DATE NOT NULL, patient_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE38F844BCC19D8 ON appointment (drug_id_id)');
        $this->addSql('CREATE INDEX IDX_FE38F8444DE7C79 ON appointment (consultation_id_id)');
        $this->addSql('CREATE TABLE appointment_user (appointment_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(appointment_id, user_id))');
        $this->addSql('CREATE INDEX IDX_9E501E88E5B533F9 ON appointment_user (appointment_id)');
        $this->addSql('CREATE INDEX IDX_9E501E88A76ED395 ON appointment_user (user_id)');
        $this->addSql('CREATE TABLE clinic (id INT NOT NULL, name VARCHAR(100) NOT NULL, country VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE consultation (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE document_storage (id INT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F015BDE89D86650F ON document_storage (user_id_id)');
        $this->addSql('CREATE TABLE drug (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, price INT NOT NULL, stock INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE speciality (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844BCC19D8 FOREIGN KEY (drug_id_id) REFERENCES drug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8444DE7C79 FOREIGN KEY (consultation_id_id) REFERENCES consultation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment_user ADD CONSTRAINT FK_9E501E88E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment_user ADD CONSTRAINT FK_9E501E88A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_storage ADD CONSTRAINT FK_F015BDE89D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD clinic_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD speciality_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD firstname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD gender VARCHAR(1) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F6C03764 FOREIGN KEY (clinic_id_id) REFERENCES clinic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6493B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649F6C03764 ON "user" (clinic_id_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493B5A08D7 ON "user" (speciality_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F6C03764');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6493B5A08D7');
        $this->addSql('DROP SEQUENCE appointment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE clinic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE consultation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_storage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drug_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE speciality_id_seq CASCADE');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F844BCC19D8');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F8444DE7C79');
        $this->addSql('ALTER TABLE appointment_user DROP CONSTRAINT FK_9E501E88E5B533F9');
        $this->addSql('ALTER TABLE appointment_user DROP CONSTRAINT FK_9E501E88A76ED395');
        $this->addSql('ALTER TABLE document_storage DROP CONSTRAINT FK_F015BDE89D86650F');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE appointment_user');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE document_storage');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP INDEX IDX_8D93D649F6C03764');
        $this->addSql('DROP INDEX IDX_8D93D6493B5A08D7');
        $this->addSql('ALTER TABLE "user" DROP clinic_id_id');
        $this->addSql('ALTER TABLE "user" DROP speciality_id');
        $this->addSql('ALTER TABLE "user" DROP firstname');
        $this->addSql('ALTER TABLE "user" DROP lastname');
        $this->addSql('ALTER TABLE "user" DROP gender');
    }
}
