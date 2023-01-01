<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230164313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, ad VARCHAR(255) NOT NULL, soyad VARCHAR(255) NOT NULL, ise_giris_tarihi DATE NOT NULL, isten_cikis_tarihi DATE DEFAULT NULL, sgk_sicil_no VARCHAR(255) NOT NULL, tc_kimlik_no INT NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1C3D28BAB (sgk_sicil_no), UNIQUE INDEX UNIQ_5D9F75A160E321A6 (tc_kimlik_no), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE employee');
    }
}
