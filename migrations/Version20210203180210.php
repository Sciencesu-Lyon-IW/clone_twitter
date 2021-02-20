<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203180210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', body VARCHAR(245) DEFAULT NULL, INDEX fk_comments_posts1_idx (posts_id), INDEX fk_comments_user1_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE followers (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) DEFAULT NULL, abonné VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', createAt DATETIME DEFAULT NULL, INDEX fk_likes_posts1_idx (posts_id), INDEX fk_likes_user1_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_user (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) DEFAULT NULL, media_path VARCHAR(245) DEFAULT NULL, size INT DEFAULT NULL, extension VARCHAR(45) DEFAULT NULL, createAt DATETIME DEFAULT NULL, updateAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_user_has_user (media_user_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_D425D7B7C6B955DC (media_user_id), INDEX IDX_D425D7B7A76ED395 (user_id), PRIMARY KEY(media_user_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, body VARCHAR(245) DEFAULT NULL, picture_path VARCHAR(245) DEFAULT NULL, size INT DEFAULT NULL, extension VARCHAR(45) DEFAULT NULL, createAt VARCHAR(255) DEFAULT NULL, updateAt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_cover_user (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) DEFAULT NULL, picture_path VARCHAR(245) DEFAULT NULL, size INT DEFAULT NULL, extension VARCHAR(45) DEFAULT NULL, creatAt DATETIME DEFAULT NULL, updateAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_picture_user (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) DEFAULT NULL, picture_path VARCHAR(245) DEFAULT NULL, size INT DEFAULT NULL, extension VARCHAR(45) DEFAULT NULL, creatAt DATETIME DEFAULT NULL, updateAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repost (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', createAt DATETIME DEFAULT NULL, INDEX fk_repost_posts1_idx (posts_id), INDEX fk_repost_user1_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', profile_cover_user_id INT DEFAULT NULL, profile_picture_user_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(45) NOT NULL, username VARCHAR(45) NOT NULL, firstname VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, birthdate DATE NOT NULL, bio VARCHAR(245) DEFAULT NULL, location VARCHAR(45) DEFAULT NULL, creatAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX fk_user_profile_cover_user1_idx (profile_cover_user_id), INDEX fk_user_profile_picture_user_idx (profile_picture_user_id), UNIQUE INDEX email_UNIQUE (email), UNIQUE INDEX firstname_UNIQUE (firstname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_has_followers (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', followers_id INT NOT NULL, INDEX IDX_4B23C2B8A76ED395 (user_id), INDEX IDX_4B23C2B815BF9993 (followers_id), PRIMARY KEY(user_id, followers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE media_user_has_user ADD CONSTRAINT FK_D425D7B7C6B955DC FOREIGN KEY (media_user_id) REFERENCES media_user (id)');
        $this->addSql('ALTER TABLE media_user_has_user ADD CONSTRAINT FK_D425D7B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C5D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498180F7FD FOREIGN KEY (profile_cover_user_id) REFERENCES profile_cover_user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D70E896D FOREIGN KEY (profile_picture_user_id) REFERENCES profile_picture_user (id)');
        $this->addSql('ALTER TABLE user_has_followers ADD CONSTRAINT FK_4B23C2B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_has_followers ADD CONSTRAINT FK_4B23C2B815BF9993 FOREIGN KEY (followers_id) REFERENCES followers (id)');
        $this->addSql('ALTER TABLE posts_user ADD CONSTRAINT FK_37C3EFF0D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_user ADD CONSTRAINT FK_37C3EFF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_has_followers DROP FOREIGN KEY FK_4B23C2B815BF9993');
        $this->addSql('ALTER TABLE media_user_has_user DROP FOREIGN KEY FK_D425D7B7C6B955DC');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AD5E258C5');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DD5E258C5');
        $this->addSql('ALTER TABLE posts_user DROP FOREIGN KEY FK_37C3EFF0D5E258C5');
        $this->addSql('ALTER TABLE repost DROP FOREIGN KEY FK_DD3446C5D5E258C5');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498180F7FD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D70E896D');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('ALTER TABLE media_user_has_user DROP FOREIGN KEY FK_D425D7B7A76ED395');
        $this->addSql('ALTER TABLE posts_user DROP FOREIGN KEY FK_37C3EFF0A76ED395');
        $this->addSql('ALTER TABLE repost DROP FOREIGN KEY FK_DD3446C5A76ED395');
        $this->addSql('ALTER TABLE user_has_followers DROP FOREIGN KEY FK_4B23C2B8A76ED395');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE followers');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE media_user');
        $this->addSql('DROP TABLE media_user_has_user');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE profile_cover_user');
        $this->addSql('DROP TABLE profile_picture_user');
        $this->addSql('DROP TABLE repost');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_has_followers');
    }
}
