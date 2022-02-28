<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228191716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, recruteur_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_F65593E5BB0859F1 (recruteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, userid_id INT DEFAULT NULL, cvname VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_6AB5B47158E0A285 (userid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulant (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, candidat_id INT NOT NULL, valide TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F79395128805AB2F (annonce_id), UNIQUE INDEX UNIQ_F79395128D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruteur (id INT AUTO_INCREMENT NOT NULL, userid_id INT DEFAULT NULL, entreprise VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2BD3678C58E0A285 (userid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, recruteur_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(45) NOT NULL, prenom VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649BB0859F1 (recruteur_id), UNIQUE INDEX UNIQ_8D93D6498D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B47158E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE postulant ADD CONSTRAINT FK_F79395128805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE postulant ADD CONSTRAINT FK_F79395128D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678C58E0A285 FOREIGN KEY (userid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulant DROP FOREIGN KEY FK_F79395128805AB2F');
        $this->addSql('ALTER TABLE postulant DROP FOREIGN KEY FK_F79395128D0EB82');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498D0EB82');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BB0859F1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BB0859F1');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B47158E0A285');
        $this->addSql('ALTER TABLE recruteur DROP FOREIGN KEY FK_2BD3678C58E0A285');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE postulant');
        $this->addSql('DROP TABLE recruteur');
        $this->addSql('DROP TABLE user');
    }
}
