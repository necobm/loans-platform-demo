<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514163852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_financial_preferences_id_seq CASCADE');
        $this->addSql('CREATE TABLE client_financial_preferences (id SERIAL NOT NULL, client_id INT NOT NULL, product_type_id INT NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, max_term INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_21F3374519EB6921 ON client_financial_preferences (client_id)');
        $this->addSql('CREATE INDEX IDX_21F3374514959723 ON client_financial_preferences (product_type_id)');
        $this->addSql('CREATE TABLE client_product (id SERIAL NOT NULL, client_id INT NOT NULL, product_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date DATE NOT NULL, interest_rate INT NOT NULL, monthly_fee DOUBLE PRECISION NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_817740D019EB6921 ON client_product (client_id)');
        $this->addSql('CREATE INDEX IDX_817740D04584665A ON client_product (product_id)');
        $this->addSql('ALTER TABLE client_financial_preferences ADD CONSTRAINT FK_21F3374519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_financial_preferences ADD CONSTRAINT FK_21F3374514959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_product ADD CONSTRAINT FK_817740D019EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_product ADD CONSTRAINT FK_817740D04584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_financial_preferences DROP CONSTRAINT fk_6b02111719eb6921');
        $this->addSql('ALTER TABLE user_financial_preferences DROP CONSTRAINT fk_6b02111714959723');
        $this->addSql('ALTER TABLE user_product DROP CONSTRAINT fk_8b471aa74584665a');
        $this->addSql('ALTER TABLE user_product DROP CONSTRAINT fk_8b471aa719eb6921');
        $this->addSql('DROP TABLE user_financial_preferences');
        $this->addSql('DROP TABLE user_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_financial_preferences_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_financial_preferences (id SERIAL NOT NULL, client_id INT NOT NULL, product_type_id INT NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, max_term INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6b02111714959723 ON user_financial_preferences (product_type_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_6b02111719eb6921 ON user_financial_preferences (client_id)');
        $this->addSql('CREATE TABLE user_product (id SERIAL NOT NULL, client_id INT NOT NULL, product_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date DATE NOT NULL, interest_rate INT NOT NULL, monthly_fee DOUBLE PRECISION NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_8b471aa719eb6921 ON user_product (client_id)');
        $this->addSql('CREATE INDEX idx_8b471aa74584665a ON user_product (product_id)');
        $this->addSql('ALTER TABLE user_financial_preferences ADD CONSTRAINT fk_6b02111719eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_financial_preferences ADD CONSTRAINT fk_6b02111714959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT fk_8b471aa74584665a FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT fk_8b471aa719eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_financial_preferences DROP CONSTRAINT FK_21F3374519EB6921');
        $this->addSql('ALTER TABLE client_financial_preferences DROP CONSTRAINT FK_21F3374514959723');
        $this->addSql('ALTER TABLE client_product DROP CONSTRAINT FK_817740D019EB6921');
        $this->addSql('ALTER TABLE client_product DROP CONSTRAINT FK_817740D04584665A');
        $this->addSql('DROP TABLE client_financial_preferences');
        $this->addSql('DROP TABLE client_product');
    }
}
