<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219223311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certificat (id INT AUTO_INCREMENT NOT NULL, duree DOUBLE PRECISION NOT NULL, domaine VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, technologies VARCHAR(100) NOT NULL, niveau VARCHAR(20) NOT NULL, INDEX IDX_DB2077CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplome (id INT AUTO_INCREMENT NOT NULL, montion VARCHAR(15) NOT NULL, annee DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, diplome_id INT DEFAULT NULL, user_id INT DEFAULT NULL, annee DOUBLE PRECISION NOT NULL, specialite VARCHAR(255) NOT NULL, INDEX IDX_DB0A5ED226F859E2 (diplome_id), INDEX IDX_DB0A5ED2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, user_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_590C103C18272 (projet_id), INDEX IDX_590C103A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, experience_id INT DEFAULT NULL, poste VARCHAR(30) NOT NULL, INDEX IDX_9067F23C46E90E27 (experience_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE multimedia (id INT AUTO_INCREMENT NOT NULL, projetspersonnel_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, lien VARCHAR(30) NOT NULL, INDEX IDX_61312863F46E4584 (projetspersonnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametres (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, loisires VARCHAR(255) NOT NULL, informations VARCHAR(255) NOT NULL, paragraphe VARCHAR(255) NOT NULL, INDEX IDX_1A79799DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, technologies VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projetpersonnel (id INT AUTO_INCREMENT NOT NULL, idee VARCHAR(50) NOT NULL, suree VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projetspersonnel (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, idee VARCHAR(50) NOT NULL, duree DOUBLE PRECISION NOT NULL, technologies VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_D023F754A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_certificat (user_id INT NOT NULL, certificat_id INT NOT NULL, INDEX IDX_8023499BA76ED395 (user_id), INDEX IDX_8023499BFA55BACF (certificat_id), PRIMARY KEY(user_id, certificat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competences ADD CONSTRAINT FK_DB2077CEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED226F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_61312863F46E4584 FOREIGN KEY (projetspersonnel_id) REFERENCES projetspersonnel (id)');
        $this->addSql('ALTER TABLE parametres ADD CONSTRAINT FK_1A79799DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE projetspersonnel ADD CONSTRAINT FK_D023F754A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_certificat ADD CONSTRAINT FK_8023499BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_certificat ADD CONSTRAINT FK_8023499BFA55BACF FOREIGN KEY (certificat_id) REFERENCES certificat (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competences DROP FOREIGN KEY FK_DB2077CEA76ED395');
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED226F859E2');
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED2A76ED395');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103C18272');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103A76ED395');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C46E90E27');
        $this->addSql('ALTER TABLE multimedia DROP FOREIGN KEY FK_61312863F46E4584');
        $this->addSql('ALTER TABLE parametres DROP FOREIGN KEY FK_1A79799DA76ED395');
        $this->addSql('ALTER TABLE projetspersonnel DROP FOREIGN KEY FK_D023F754A76ED395');
        $this->addSql('ALTER TABLE user_certificat DROP FOREIGN KEY FK_8023499BA76ED395');
        $this->addSql('ALTER TABLE user_certificat DROP FOREIGN KEY FK_8023499BFA55BACF');
        $this->addSql('DROP TABLE certificat');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE multimedia');
        $this->addSql('DROP TABLE parametres');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projetpersonnel');
        $this->addSql('DROP TABLE projetspersonnel');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_certificat');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
