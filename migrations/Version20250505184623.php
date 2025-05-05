<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505184623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie__movies_categories (movie_id INT NOT NULL, movie_category_id INT NOT NULL, INDEX IDX_A9FC30D08F93B6FC (movie_id), INDEX IDX_A9FC30D03DC01115 (movie_category_id), PRIMARY KEY(movie_id, movie_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie__movie_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie__movies_categories ADD CONSTRAINT FK_A9FC30D08F93B6FC FOREIGN KEY (movie_id) REFERENCES movie__movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie__movies_categories ADD CONSTRAINT FK_A9FC30D03DC01115 FOREIGN KEY (movie_category_id) REFERENCES movie__movie_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie__movies_categories DROP FOREIGN KEY FK_A9FC30D08F93B6FC');
        $this->addSql('ALTER TABLE movie__movies_categories DROP FOREIGN KEY FK_A9FC30D03DC01115');
        $this->addSql('DROP TABLE movie__movies_categories');
        $this->addSql('DROP TABLE movie__movie_category');
    }
}
