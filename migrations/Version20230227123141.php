<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227123141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, professeur_id INT NOT NULL, nom_classe VARCHAR(255) NOT NULL, INDEX IDX_2ED7EC5BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleves (id INT AUTO_INCREMENT NOT NULL, classe_eleve_id INT NOT NULL, nom_eleve VARCHAR(255) NOT NULL, prenom_eleve VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, INDEX IDX_383B09B130A20F1C (classe_eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeurs (id INT AUTO_INCREMENT NOT NULL, nom_professeur VARCHAR(255) NOT NULL, prenom_professeur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B130A20F1C FOREIGN KEY (classe_eleve_id) REFERENCES classes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC5BAB22EE9');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B130A20F1C');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE eleves');
        $this->addSql('DROP TABLE professeurs');
    }
}
