<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219193957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD created_at VARCHAR(255) DEFAULT NULL, ADD updated_at VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX firstname_UNIQUE ON user (firstname)');
        $this->addSql('ALTER TABLE user_has_followers CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX fk_user_has_followers_user1_idx TO IDX_4B23C2B8A76ED395');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX fk_user_has_followers_followers1_idx TO IDX_4B23C2B815BF9993');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX firstname_UNIQUE ON user');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL, CHANGE email email VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE roles roles JSON DEFAULT NULL, CHANGE password password VARCHAR(245) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE username username VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE firstname firstname VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE name name VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE birthdate birthdate DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_has_followers CHANGE user_id user_id BINARY(16) NOT NULL');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX idx_4b23c2b815bf9993 TO fk_user_has_followers_followers1_idx');
        $this->addSql('ALTER TABLE user_has_followers RENAME INDEX idx_4b23c2b8a76ed395 TO fk_user_has_followers_user1_idx');
    }
}
