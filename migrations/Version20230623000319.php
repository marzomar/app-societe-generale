<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623000319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD combinaison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D9D0413F FOREIGN KEY (combinaison_id) REFERENCES combinaison (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D9D0413F ON user (combinaison_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D9D0413F');
        $this->addSql('DROP INDEX IDX_8D93D649D9D0413F ON `user`');
        $this->addSql('ALTER TABLE `user` DROP combinaison_id');
    }
}
