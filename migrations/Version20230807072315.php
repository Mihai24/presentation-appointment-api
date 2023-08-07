<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230807072315 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE enrollments (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', presentation_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, INDEX IDX_CCD8C132AB627E8B (presentation_id), INDEX IDX_CCD8C132A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentations (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', organizer_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_72936B1D876C4DDA (organizer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enrollments ADD CONSTRAINT FK_CCD8C132AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentations (id)');
        $this->addSql('ALTER TABLE enrollments ADD CONSTRAINT FK_CCD8C132A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE presentations ADD CONSTRAINT FK_72936B1D876C4DDA FOREIGN KEY (organizer_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE enrollments DROP FOREIGN KEY FK_CCD8C132AB627E8B');
        $this->addSql('ALTER TABLE enrollments DROP FOREIGN KEY FK_CCD8C132A76ED395');
        $this->addSql('ALTER TABLE presentations DROP FOREIGN KEY FK_72936B1D876C4DDA');
        $this->addSql('DROP TABLE enrollments');
        $this->addSql('DROP TABLE presentations');
    }
}
