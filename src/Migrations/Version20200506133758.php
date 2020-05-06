<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506133758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Lawyer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone_number VARCHAR(100) NOT NULL, title VARCHAR(50) NOT NULL, postal_code VARCHAR(50) NOT NULL, postal_address LONGTEXT NOT NULL, country VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, company_name VARCHAR(255) DEFAULT NULL, lawyer_licence_number VARCHAR(100) NOT NULL, lawyer_license_issue_date DATE NOT NULL, lawyer_license_expire_date DATE NOT NULL, lawyer_license_name VARCHAR(100) DEFAULT NULL, lawyer_degree VARCHAR(100) NOT NULL, type_of_lawyer VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_66437141E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE citizen CHANGE postal_code postal_code VARCHAR(50) DEFAULT NULL, CHANGE country country VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Lawyer');
        $this->addSql('ALTER TABLE Citizen CHANGE postal_code postal_code VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
