<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190718102328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE translations_translations (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, translation VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_F46F530A2C2AC5D3 (translatable_id), UNIQUE INDEX translations_translations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translations (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, INDEX locale_domain_idx (source, domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translations_translations ADD CONSTRAINT FK_F46F530A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES translations (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translations_translations DROP FOREIGN KEY FK_F46F530A2C2AC5D3');
        $this->addSql('DROP TABLE translations_translations');
        $this->addSql('DROP TABLE translations');
    }
}
