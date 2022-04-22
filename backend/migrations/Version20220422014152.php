<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422014152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ALTER content TYPE VARCHAR(320)');
        $this->addSql('ALTER TABLE gallery ADD nsfw BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE image ADD src VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE image ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gallery DROP nsfw');
        $this->addSql('ALTER TABLE image DROP src');
        $this->addSql('ALTER TABLE image ALTER id TYPE INT');
        $this->addSql('ALTER TABLE image ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE comment ALTER content TYPE VARCHAR(255)');
    }
}
