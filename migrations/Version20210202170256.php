<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202170256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_user_has_user (media_user_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_D425D7B7C6B955DC (media_user_id), INDEX IDX_D425D7B7A76ED395 (user_id), PRIMARY KEY(media_user_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts_user (posts_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_37C3EFF0D5E258C5 (posts_id), INDEX IDX_37C3EFF0A76ED395 (user_id), PRIMARY KEY(posts_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_user_has_user ADD CONSTRAINT FK_D425D7B7C6B955DC FOREIGN KEY (media_user_id) REFERENCES media_user (id)');
        $this->addSql('ALTER TABLE media_user_has_user ADD CONSTRAINT FK_D425D7B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posts_user ADD CONSTRAINT FK_37C3EFF0D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_user ADD CONSTRAINT FK_37C3EFF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_has_media_user');
        $this->addSql('ALTER TABLE posts CHANGE body body VARCHAR(245) DEFAULT NULL');
        $this->addSql('ALTER TABLE repost CHANGE posts_id posts_id INT DEFAULT NULL, CHANGE user_id user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(45) NOT NULL, CHANGE username username VARCHAR(45) NOT NULL, CHANGE firstname firstname VARCHAR(45) NOT NULL, CHANGE name name VARCHAR(45) NOT NULL, CHANGE birthdate birthdate DATE NOT NULL');
        $this->addSql('ALTER TABLE user_has_followers CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX fk_user_has_followers_user1_idx TO IDX_4B23C2B8A76ED395');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX fk_user_has_followers_followers1_idx TO IDX_4B23C2B815BF9993');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_has_media_user (user_id BINARY(16) NOT NULL, media_user_id INT NOT NULL, INDEX fk_user_has_media_user_media_user1_idx (media_user_id), INDEX fk_user_has_media_user_user1_idx (user_id), PRIMARY KEY(user_id, media_user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_has_media_user ADD CONSTRAINT fk_user_has_media_user_media_user1 FOREIGN KEY (media_user_id) REFERENCES media_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_has_media_user ADD CONSTRAINT fk_user_has_media_user_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE media_user_has_user');
        $this->addSql('DROP TABLE posts_user');
        $this->addSql('ALTER TABLE posts CHANGE body body VARCHAR(245) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE repost CHANGE posts_id posts_id INT NOT NULL, CHANGE user_id user_id BINARY(16) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL, CHANGE email email VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE roles roles JSON DEFAULT NULL, CHANGE password password VARCHAR(245) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE username username VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE firstname firstname VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE name name VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE birthdate birthdate DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_has_followers CHANGE user_id user_id BINARY(16) NOT NULL');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX idx_4b23c2b815bf9993 TO fk_user_has_followers_followers1_idx');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX idx_4b23c2b8a76ed395 TO fk_user_has_followers_user1_idx');
    }
}
