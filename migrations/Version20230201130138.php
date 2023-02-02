<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201130138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD uuid VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, DROP surname, DROP ville, DROP code_postal, DROP pays, DROP rue, DROP num_rue, DROP tel, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON user (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649D17F50A6 ON user');
        $this->addSql('ALTER TABLE user ADD surname VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) DEFAULT NULL, ADD code_postal INT DEFAULT NULL, ADD pays VARCHAR(255) DEFAULT NULL, ADD rue VARCHAR(255) DEFAULT NULL, ADD num_rue INT DEFAULT NULL, ADD tel INT DEFAULT NULL, DROP uuid, DROP roles, CHANGE name name VARCHAR(255) NOT NULL');
    }
}
