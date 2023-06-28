<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230622225650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE association (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choice (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, go_back INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE combinaison (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, choice1_id INT DEFAULT NULL, choice2_id INT DEFAULT NULL, choice3_id INT DEFAULT NULL, choice4_id INT DEFAULT NULL, INDEX IDX_6DCBB34B1E27F6BF (question_id), INDEX IDX_6DCBB34B272149B7 (choice1_id), INDEX IDX_6DCBB34B3594E659 (choice2_id), INDEX IDX_6DCBB34B8D28813C (choice3_id), INDEX IDX_6DCBB34B10FFB985 (choice4_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE combinaison_association (combinaison_id INT NOT NULL, association_id INT NOT NULL, INDEX IDX_9D30BEBD9D0413F (combinaison_id), INDEX IDX_9D30BEBEFB9C8A5 (association_id), PRIMARY KEY(combinaison_id, association_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE combinaison_choice (combinaison_id INT NOT NULL, choice_id INT NOT NULL, INDEX IDX_B5430B5DD9D0413F (combinaison_id), INDEX IDX_B5430B5D998666D1 (choice_id), PRIMARY KEY(combinaison_id, choice_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34B272149B7 FOREIGN KEY (choice1_id) REFERENCES choice (id)');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34B3594E659 FOREIGN KEY (choice2_id) REFERENCES choice (id)');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34B8D28813C FOREIGN KEY (choice3_id) REFERENCES choice (id)');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34B10FFB985 FOREIGN KEY (choice4_id) REFERENCES choice (id)');
        $this->addSql('ALTER TABLE combinaison_association ADD CONSTRAINT FK_9D30BEBD9D0413F FOREIGN KEY (combinaison_id) REFERENCES combinaison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE combinaison_association ADD CONSTRAINT FK_9D30BEBEFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE combinaison_choice ADD CONSTRAINT FK_B5430B5DD9D0413F FOREIGN KEY (combinaison_id) REFERENCES combinaison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE combinaison_choice ADD CONSTRAINT FK_B5430B5D998666D1 FOREIGN KEY (choice_id) REFERENCES choice (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combinaison DROP FOREIGN KEY FK_6DCBB34B1E27F6BF');
        $this->addSql('ALTER TABLE combinaison DROP FOREIGN KEY FK_6DCBB34B272149B7');
        $this->addSql('ALTER TABLE combinaison DROP FOREIGN KEY FK_6DCBB34B3594E659');
        $this->addSql('ALTER TABLE combinaison DROP FOREIGN KEY FK_6DCBB34B8D28813C');
        $this->addSql('ALTER TABLE combinaison DROP FOREIGN KEY FK_6DCBB34B10FFB985');
        $this->addSql('ALTER TABLE combinaison_association DROP FOREIGN KEY FK_9D30BEBD9D0413F');
        $this->addSql('ALTER TABLE combinaison_association DROP FOREIGN KEY FK_9D30BEBEFB9C8A5');
        $this->addSql('ALTER TABLE combinaison_choice DROP FOREIGN KEY FK_B5430B5DD9D0413F');
        $this->addSql('ALTER TABLE combinaison_choice DROP FOREIGN KEY FK_B5430B5D998666D1');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE choice');
        $this->addSql('DROP TABLE combinaison');
        $this->addSql('DROP TABLE combinaison_association');
        $this->addSql('DROP TABLE combinaison_choice');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
