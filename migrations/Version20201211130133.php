<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211130133 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, style VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, yearofcreation VARCHAR(255) NOT NULL, lastalbumname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_hall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, concert_hall_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_1B8FA83FC8B57370 (concert_hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_70E4FA7849ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, hall_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_320ED90149ABEB17 (band_id), INDEX IDX_320ED90152AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83FC8B57370 FOREIGN KEY (concert_hall_id) REFERENCES concert_hall (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7849ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90149ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90152AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7849ABEB17');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED90149ABEB17');
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FC8B57370');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED90152AFCFD6');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE concert_hall');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE `show`');
    }
}
