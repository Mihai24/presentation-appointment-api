<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230808092059 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE enrollments ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE presentations ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP deleted_at');
        $this->addSql('ALTER TABLE enrollments DROP deleted_at');
        $this->addSql('ALTER TABLE presentations DROP deleted_at');
    }
}
