<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230513123755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_product (id SERIAL NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date DATE NOT NULL, interest_rate INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B471AA7A76ED395 ON user_product (user_id)');
        $this->addSql('CREATE INDEX IDX_8B471AA74584665A ON user_product (product_id)');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA7A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA74584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD minimal_income_requirement DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD adicional_costs DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_product DROP CONSTRAINT FK_8B471AA7A76ED395');
        $this->addSql('ALTER TABLE user_product DROP CONSTRAINT FK_8B471AA74584665A');
        $this->addSql('DROP TABLE user_product');
        $this->addSql('ALTER TABLE product DROP minimal_income_requirement');
        $this->addSql('ALTER TABLE product DROP adicional_costs');
    }
}
