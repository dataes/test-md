<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430151152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO language (iso_code) VALUES ("fr")');
        $this->addSql('INSERT INTO language (iso_code) VALUES ("nl")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM language WHERE iso_code="fr"');
        $this->addSql('DELETE FROM language WHERE iso_code="nl"');
    }
}
