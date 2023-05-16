<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230513132346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_product DROP CONSTRAINT fk_8b471aa7a76ed395');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE TABLE client (id SERIAL NOT NULL, name VARCHAR(128) NOT NULL, surname VARCHAR(128) NOT NULL, age INT NOT NULL, email VARCHAR(128) NOT NULL, city VARCHAR(256) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP INDEX idx_8b471aa7a76ed395');
        $this->addSql('ALTER TABLE user_product RENAME COLUMN user_id TO client_id');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8B471AA719EB6921 ON user_product (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_product DROP CONSTRAINT FK_8B471AA719EB6921');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, name VARCHAR(128) NOT NULL, surname VARCHAR(128) NOT NULL, age INT NOT NULL, email VARCHAR(128) NOT NULL, city VARCHAR(256) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON "user" (email)');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP INDEX IDX_8B471AA719EB6921');
        $this->addSql('ALTER TABLE user_product RENAME COLUMN client_id TO user_id');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT fk_8b471aa7a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8b471aa7a76ed395 ON user_product (user_id)');
    }
}
