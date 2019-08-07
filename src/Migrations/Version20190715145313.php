<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715145313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE emails_templates_translations (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_DEF1E8322C2AC5D3 (translatable_id), UNIQUE INDEX emails_templates_translations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emails_templates_translations ADD CONSTRAINT FK_DEF1E8322C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES emails_templates (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emails_templates DROP subject, DROP message');

        $this->addSql("INSERT INTO emails_templates_translations VALUES(null, 1, 'Contact from {siteName}', '<p><b>Name</b>: {userName}</p><p><b>Email</b>: {userEmail}</p><p><b>Message</b>: {userMessage}</p>', 'en')");
        $this->addSql("INSERT INTO emails_templates_translations VALUES(null, 1, 'Contact from {siteName}', '<p><b>Name</b>: {userName}</p><p><b>Email</b>: {userEmail}</p><p><b>Message</b>: {userMessage}</p>', 'de')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE emails_templates_translations');
        $this->addSql('ALTER TABLE emails_templates ADD subject VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD message LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql("UPDATE emails_templates SET subject = 'Contact from {siteName}', message = '<p><b>Name</b>: {userName}</p><p><b>Email</b>: {userEmail}</p><p><b>Message</b>: {userMessage}</p>' WHERE id = 1");
    }
}
