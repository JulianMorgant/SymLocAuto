<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190211094733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE consumer (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, create_at DATETIME NOT NULL, modify_at DATETIME NOT NULL, address VARCHAR(100) NOT NULL, INDEX IDX_705B37279D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(20) NOT NULL, mail VARCHAR(50) NOT NULL, psw VARCHAR(20) NOT NULL, create_at DATETIME NOT NULL, modify_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consumer ADD CONSTRAINT FK_705B37279D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consumer DROP FOREIGN KEY FK_705B37279D86650F');
        $this->addSql('DROP TABLE consumer');
        $this->addSql('DROP TABLE user');
    }
}
