<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430112043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, iso_code VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_notification_block_content (language_id INT NOT NULL, notification_block_content_id INT NOT NULL, INDEX IDX_D49AC3C382F1BAF4 (language_id), INDEX IDX_D49AC3C36349E87B (notification_block_content_id), PRIMARY KEY(language_id, notification_block_content_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, activation_date TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_block (id INT AUTO_INCREMENT NOT NULL, notification_id INT NOT NULL, user_validation TINYINT(1) NOT NULL, INDEX IDX_45AF72DBEF1A9D84 (notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_block_content (id INT AUTO_INCREMENT NOT NULL, notification_block_id INT NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_D2540E9EBCFDBAA9 (notification_block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE language_notification_block_content ADD CONSTRAINT FK_D49AC3C382F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_notification_block_content ADD CONSTRAINT FK_D49AC3C36349E87B FOREIGN KEY (notification_block_content_id) REFERENCES notification_block_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_block ADD CONSTRAINT FK_45AF72DBEF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE notification_block_content ADD CONSTRAINT FK_D2540E9EBCFDBAA9 FOREIGN KEY (notification_block_id) REFERENCES notification_block (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE language_notification_block_content DROP FOREIGN KEY FK_D49AC3C382F1BAF4');
        $this->addSql('ALTER TABLE notification_block DROP FOREIGN KEY FK_45AF72DBEF1A9D84');
        $this->addSql('ALTER TABLE notification_block_content DROP FOREIGN KEY FK_D2540E9EBCFDBAA9');
        $this->addSql('ALTER TABLE language_notification_block_content DROP FOREIGN KEY FK_D49AC3C36349E87B');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_notification_block_content');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_block');
        $this->addSql('DROP TABLE notification_block_content');
    }
}
