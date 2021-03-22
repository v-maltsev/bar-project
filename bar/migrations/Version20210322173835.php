<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322173835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE composition (id INT AUTO_INCREMENT NOT NULL, genre_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C7F43474296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play_list (id INT AUTO_INCREMENT NOT NULL, composition_id INT DEFAULT NULL, INDEX IDX_4FCD06C987A2E12 (composition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor_genre (visitor_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_8D75370170BEE6D (visitor_id), INDEX IDX_8D7537014296D31F (genre_id), PRIMARY KEY(visitor_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F43474296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE play_list ADD CONSTRAINT FK_4FCD06C987A2E12 FOREIGN KEY (composition_id) REFERENCES composition (id)');
        $this->addSql('ALTER TABLE visitor_genre ADD CONSTRAINT FK_8D75370170BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visitor_genre ADD CONSTRAINT FK_8D7537014296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE play_list DROP FOREIGN KEY FK_4FCD06C987A2E12');
        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F43474296D31F');
        $this->addSql('ALTER TABLE visitor_genre DROP FOREIGN KEY FK_8D7537014296D31F');
        $this->addSql('ALTER TABLE visitor_genre DROP FOREIGN KEY FK_8D75370170BEE6D');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE play_list');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE visitor_genre');
    }
}
