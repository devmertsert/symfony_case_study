<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230101155104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permit (id INT AUTO_INCREMENT NOT NULL, employee_id_id INT NOT NULL, izin_baslangic_tarihi DATE NOT NULL, izin_bitis_tarihi DATE NOT NULL, INDEX IDX_895C01F09749932E (employee_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permit ADD CONSTRAINT FK_895C01F09749932E FOREIGN KEY (employee_id_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permit DROP FOREIGN KEY FK_895C01F09749932E');
        $this->addSql('DROP TABLE permit');
    }
}
