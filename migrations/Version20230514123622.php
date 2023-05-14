<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514123622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_recommendation (id SERIAL NOT NULL, client_id INT NOT NULL, product_id INT NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_status_changed TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, interest_rate INT NOT NULL, monthly_fee DOUBLE PRECISION NOT NULL, loan_term INT NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_105B5AFE19EB6921 ON product_recommendation (client_id)');
        $this->addSql('CREATE INDEX IDX_105B5AFE4584665A ON product_recommendation (product_id)');
        $this->addSql('CREATE TABLE user_financial_preferences (id SERIAL NOT NULL, client_id INT NOT NULL, product_type_id INT NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, max_term INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B02111719EB6921 ON user_financial_preferences (client_id)');
        $this->addSql('CREATE INDEX IDX_6B02111714959723 ON user_financial_preferences (product_type_id)');
        $this->addSql('ALTER TABLE product_recommendation ADD CONSTRAINT FK_105B5AFE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_recommendation ADD CONSTRAINT FK_105B5AFE4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_financial_preferences ADD CONSTRAINT FK_6B02111719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_financial_preferences ADD CONSTRAINT FK_6B02111714959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD net_monthly_income DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE client ADD total_monthly_spends DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user_product ADD monthly_fee DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user_product ADD status VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product_recommendation DROP CONSTRAINT FK_105B5AFE19EB6921');
        $this->addSql('ALTER TABLE product_recommendation DROP CONSTRAINT FK_105B5AFE4584665A');
        $this->addSql('ALTER TABLE user_financial_preferences DROP CONSTRAINT FK_6B02111719EB6921');
        $this->addSql('ALTER TABLE user_financial_preferences DROP CONSTRAINT FK_6B02111714959723');
        $this->addSql('DROP TABLE product_recommendation');
        $this->addSql('DROP TABLE user_financial_preferences');
        $this->addSql('ALTER TABLE client DROP net_monthly_income');
        $this->addSql('ALTER TABLE client DROP total_monthly_spends');
        $this->addSql('ALTER TABLE user_product DROP monthly_fee');
        $this->addSql('ALTER TABLE user_product DROP status');
    }
}
