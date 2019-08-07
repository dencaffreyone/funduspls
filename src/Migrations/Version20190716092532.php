<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190716092532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contents_text_blocks_translations (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, content LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_12496A852C2AC5D3 (translatable_id), UNIQUE INDEX contents_text_blocks_translations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents_pages_translations (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, meta_title VARCHAR(255) NOT NULL, meta_keywords VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_2CA098F82C2AC5D3 (translatable_id), UNIQUE INDEX contents_pages_translations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contents_text_blocks_translations ADD CONSTRAINT FK_12496A852C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES contents_text_blocks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents_pages_translations ADD CONSTRAINT FK_2CA098F82C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES contents_pages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents_text_blocks DROP content');
        $this->addSql('ALTER TABLE contents_pages DROP url, DROP meta_title, DROP meta_keywords, DROP meta_description, DROP content');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contents_text_blocks_translations');
        $this->addSql('DROP TABLE contents_pages_translations');
        $this->addSql('ALTER TABLE contents_pages ADD url VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD meta_title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD meta_keywords VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD meta_description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE contents_text_blocks ADD content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
