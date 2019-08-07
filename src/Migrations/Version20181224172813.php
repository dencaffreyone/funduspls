<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181224172813 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE images_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_8B556BE7727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_type ENUM(\'page\',\'text_block\', \'image\') DEFAULT \'page\', INDEX IDX_B4FA1177727ACA70 (parent_id), INDEX type_idx (content_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents_text_blocks (id INT NOT NULL, uid VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_A89040C4539B0606 (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents_pages (id INT NOT NULL, change_frequency ENUM(\'always\',\'hourly\',\'daily\',\'weekly\',\'monthly\',\'yearly\',\'never\') NOT NULL, route VARCHAR(255) NOT NULL, priority NUMERIC(2, 1) DEFAULT \'0.5\' NOT NULL, url VARCHAR(255) NOT NULL, has_meta_title TINYINT(1) DEFAULT \'0\' NOT NULL, has_meta_keywords TINYINT(1) DEFAULT \'0\' NOT NULL, has_meta_description TINYINT(1) DEFAULT \'0\' NOT NULL, has_content TINYINT(1) DEFAULT \'0\' NOT NULL, meta_title VARCHAR(255) NOT NULL, meta_keywords VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, controller_action VARCHAR(255) NOT NULL, template VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_CA672AAD2C42079 (route), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents_images (id INT NOT NULL, image_id INT DEFAULT NULL, uid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_68FDF743539B0606 (uid), INDEX IDX_68FDF7433DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, real_file_name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, size NUMERIC(10, 0) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_has_images_categories (file_image_id INT NOT NULL, file_image_category_id INT NOT NULL, INDEX IDX_65973E3C8CF5AAF0 (file_image_id), INDEX IDX_65973E3C9E12CD14 (file_image_category_id), PRIMARY KEY(file_image_id, file_image_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images_categories ADD CONSTRAINT FK_8B556BE7727ACA70 FOREIGN KEY (parent_id) REFERENCES images_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177727ACA70 FOREIGN KEY (parent_id) REFERENCES contents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents_text_blocks ADD CONSTRAINT FK_A89040C4BF396750 FOREIGN KEY (id) REFERENCES contents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents_pages ADD CONSTRAINT FK_CA672AADBF396750 FOREIGN KEY (id) REFERENCES contents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents_images ADD CONSTRAINT FK_68FDF7433DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contents_images ADD CONSTRAINT FK_68FDF743BF396750 FOREIGN KEY (id) REFERENCES contents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_has_images_categories ADD CONSTRAINT FK_65973E3C8CF5AAF0 FOREIGN KEY (file_image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_has_images_categories ADD CONSTRAINT FK_65973E3C9E12CD14 FOREIGN KEY (file_image_category_id) REFERENCES images_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE images_categories DROP FOREIGN KEY FK_8B556BE7727ACA70');
        $this->addSql('ALTER TABLE images_has_images_categories DROP FOREIGN KEY FK_65973E3C9E12CD14');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA1177727ACA70');
        $this->addSql('ALTER TABLE contents_text_blocks DROP FOREIGN KEY FK_A89040C4BF396750');
        $this->addSql('ALTER TABLE contents_pages DROP FOREIGN KEY FK_CA672AADBF396750');
        $this->addSql('ALTER TABLE contents_images DROP FOREIGN KEY FK_68FDF743BF396750');
        $this->addSql('ALTER TABLE contents_images DROP FOREIGN KEY FK_68FDF7433DA5256D');
        $this->addSql('ALTER TABLE images_has_images_categories DROP FOREIGN KEY FK_65973E3C8CF5AAF0');
        $this->addSql('DROP TABLE images_categories');
        $this->addSql('DROP TABLE contents');
        $this->addSql('DROP TABLE contents_text_blocks');
        $this->addSql('DROP TABLE contents_pages');
        $this->addSql('DROP TABLE contents_images');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_has_images_categories');
    }
}
