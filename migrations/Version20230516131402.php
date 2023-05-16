<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516131402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE client_product (id SERIAL NOT NULL, client_id INT NOT NULL, product_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date DATE NOT NULL, interest_rate INT NOT NULL, monthly_fee DOUBLE PRECISION NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_817740d04584665a ON client_product (product_id)');
        $this->addSql('CREATE INDEX idx_817740d019eb6921 ON client_product (client_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE client_financial_preferences (id SERIAL NOT NULL, client_id INT NOT NULL, product_type_id INT NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, max_term INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_21f3374514959723 ON client_financial_preferences (product_type_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_21f3374519eb6921 ON client_financial_preferences (client_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE client (id SERIAL NOT NULL, name VARCHAR(128) NOT NULL, surname VARCHAR(128) NOT NULL, age INT NOT NULL, email VARCHAR(128) NOT NULL, city VARCHAR(256) NOT NULL, net_monthly_income DOUBLE PRECISION NOT NULL, total_monthly_spends DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_c7440455e7927c74 ON client (email)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE product_type (id SERIAL NOT NULL, name VARCHAR(128) NOT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_13675881d775834 ON product_type (value)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE user_credentials (id SERIAL NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(256) NOT NULL, rol VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_531ee19be7927c74 ON user_credentials (email)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, product_type_id INT NOT NULL, name VARCHAR(128) NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, max_term INT NOT NULL, max_amount DOUBLE PRECISION NOT NULL, minimal_income_requirement DOUBLE PRECISION DEFAULT NULL, adicional_costs DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d34a04ad14959723 ON product (product_type_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE product_recommendation (id SERIAL NOT NULL, client_id INT NOT NULL, product_id INT NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_status_changed TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, interest_rate INT NOT NULL, monthly_fee DOUBLE PRECISION NOT NULL, loan_term INT NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_105b5afe4584665a ON product_recommendation (product_id)');
        $this->addSql('CREATE INDEX idx_105b5afe19eb6921 ON product_recommendation (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE client_product');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE client_financial_preferences');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE client');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE product_type');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE user_credentials');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE product');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE product_recommendation');
    }
}
