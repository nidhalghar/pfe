<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514223317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, email VARCHAR(180) NOT NULL, message LONGTEXT NOT NULL, sujet VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_certificat DROP FOREIGN KEY FK_8023499BA76ED395');
        $this->addSql('ALTER TABLE user_certificat DROP FOREIGN KEY FK_8023499BFA55BACF');
        $this->addSql('DROP TABLE projetpersonnel');
        $this->addSql('DROP TABLE user_certificat');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projetpersonnel (id INT AUTO_INCREMENT NOT NULL, idee VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, duree VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_certificat (user_id INT NOT NULL, certificat_id INT NOT NULL, INDEX IDX_8023499BA76ED395 (user_id), INDEX IDX_8023499BFA55BACF (certificat_id), PRIMARY KEY(user_id, certificat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_certificat ADD CONSTRAINT FK_8023499BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_certificat ADD CONSTRAINT FK_8023499BFA55BACF FOREIGN KEY (certificat_id) REFERENCES certificat (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE contact');
    }
}
