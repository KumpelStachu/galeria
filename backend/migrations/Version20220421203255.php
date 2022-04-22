<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421203255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE profile ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE profile ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile ALTER username TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE profile ALTER description TYPE VARCHAR(320)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FF85E0677 ON profile (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON "user" (username)');
        $this->addSql('DROP INDEX UNIQ_8157AA0FF85E0677');
        $this->addSql('ALTER TABLE profile DROP roles');
        $this->addSql('ALTER TABLE profile DROP password');
        $this->addSql('ALTER TABLE profile ALTER username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile ALTER description TYPE VARCHAR(255)');
    }
}
