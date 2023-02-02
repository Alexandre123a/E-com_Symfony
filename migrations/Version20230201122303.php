<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201122303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, id_stock_id INT NOT NULL, INDEX IDX_23A0E665D168D85 (id_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_stock (id INT AUTO_INCREMENT NOT NULL, id_type_id INT NOT NULL, id_marque_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, prix INT NOT NULL, description VARCHAR(4096) DEFAULT NULL, INDEX IDX_3C8124711BD125E3 (id_type_id), INDEX IDX_3C812471C8120595 (id_marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, id_genre_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_497DD634124D3F8A (id_genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intitule (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_panier (id INT AUTO_INCREMENT NOT NULL, id_panier_id INT NOT NULL, id_stock_id INT NOT NULL, INDEX IDX_21691B477482E5B (id_panier_id), UNIQUE INDEX UNIQ_21691B45D168D85 (id_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, UNIQUE INDEX UNIQ_24CC0DF279F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_8CDE57299F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, ville VARCHAR(255) DEFAULT NULL, code_postal INT DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, num_rue INT DEFAULT NULL, tel INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665D168D85 FOREIGN KEY (id_stock_id) REFERENCES article_stock (id)');
        $this->addSql('ALTER TABLE article_stock ADD CONSTRAINT FK_3C8124711BD125E3 FOREIGN KEY (id_type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE article_stock ADD CONSTRAINT FK_3C812471C8120595 FOREIGN KEY (id_marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634124D3F8A FOREIGN KEY (id_genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B477482E5B FOREIGN KEY (id_panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B45D168D85 FOREIGN KEY (id_stock_id) REFERENCES article_stock (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE57299F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E665D168D85');
        $this->addSql('ALTER TABLE article_stock DROP FOREIGN KEY FK_3C8124711BD125E3');
        $this->addSql('ALTER TABLE article_stock DROP FOREIGN KEY FK_3C812471C8120595');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634124D3F8A');
        $this->addSql('ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B477482E5B');
        $this->addSql('ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B45D168D85');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF279F37AE5');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE57299F34925F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_stock');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE intitule');
        $this->addSql('DROP TABLE ligne_panier');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
