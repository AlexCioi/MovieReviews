<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505200548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie__user_movie_favourite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_803A8036A76ED395 (user_id), INDEX IDX_803A80368F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie__user_movie_favourite ADD CONSTRAINT FK_803A8036A76ED395 FOREIGN KEY (user_id) REFERENCES user__user (id)');
        $this->addSql('ALTER TABLE movie__user_movie_favourite ADD CONSTRAINT FK_803A80368F93B6FC FOREIGN KEY (movie_id) REFERENCES movie__movie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie__user_movie_favourite DROP FOREIGN KEY FK_803A8036A76ED395');
        $this->addSql('ALTER TABLE movie__user_movie_favourite DROP FOREIGN KEY FK_803A80368F93B6FC');
        $this->addSql('DROP TABLE movie__user_movie_favourite');
    }
}
