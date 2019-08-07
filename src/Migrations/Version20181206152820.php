<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181206152820 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admins (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(128) NOT NULL, salt VARCHAR(64) NOT NULL, two_factor_authentication TINYINT(1) NOT NULL, two_factor_code INT DEFAULT NULL, two_factor_email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A2E0150FF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql("insert into admins values(null, 'admin', '$2a$12\$zpt.spIBWeXUb3vjZMT21eCWD6jll9sPqnbimGCR1h2VKL5WsTFiK', '!(IF#(#(V)#WV(WE(W()WEV)evoewo-EWVW#)VW#)(vw300v30V($(VI#G54', 0, null, null) ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE admins');
    }
}
