<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510144136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointment CHANGE payment_status payment_status VARCHAR(50) DEFAULT NULL, CHANGE appointment_title appointment_title VARCHAR(100) DEFAULT NULL, CHANGE appointment_type appointment_type VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE citizen CHANGE postal_code postal_code VARCHAR(50) DEFAULT NULL, CHANGE country country VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE lawyer CHANGE company_name company_name VARCHAR(255) DEFAULT NULL, CHANGE lawyer_license_name lawyer_license_name VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE token CHANGE citizen_id citizen_id INT DEFAULT NULL, CHANGE lawyer_id lawyer_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointment CHANGE payment_status payment_status VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE appointment_title appointment_title VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE appointment_type appointment_type VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Citizen CHANGE postal_code postal_code VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Lawyer CHANGE company_name company_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE lawyer_license_name lawyer_license_name VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE token CHANGE citizen_id citizen_id INT DEFAULT NULL, CHANGE lawyer_id lawyer_id INT DEFAULT NULL');
    }
}
