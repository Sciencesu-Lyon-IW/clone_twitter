<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225184913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follows (id INT AUTO_INCREMENT NOT NULL, following VARCHAR(255) NOT NULL, followers VARCHAR(255) NOT NULL, create_at VARCHAR(255) NOT NULL, update_at VARCHAR(255) DEFAULT NULL, has_follow TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(45) NOT NULL, CHANGE username username VARCHAR(45) NOT NULL, CHANGE firstname firstname VARCHAR(45) NOT NULL, CHANGE name name VARCHAR(45) NOT NULL, CHANGE birthdate birthdate DATE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX firstname_UNIQUE ON user (firstname)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE follows');
        $this->addSql('DROP INDEX firstname_UNIQUE ON user');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL, CHANGE email email VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE roles roles JSON DEFAULT NULL, CHANGE password password VARCHAR(245) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE username username VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE firstname firstname VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE name name VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE birthdate birthdate DATE DEFAULT NULL');
    }
}
