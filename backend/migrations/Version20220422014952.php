<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422014952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526cf675f31b');
        $this->addSql('DROP INDEX idx_9474526cf675f31b');
        $this->addSql('ALTER TABLE comment RENAME COLUMN author_id TO profile_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526CCCFA12B8 ON comment (profile_id)');
        $this->addSql('ALTER TABLE gallery DROP CONSTRAINT fk_472b783af675f31b');
        $this->addSql('DROP INDEX idx_472b783af675f31b');
        $this->addSql('ALTER TABLE gallery RENAME COLUMN author_id TO profile_id');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783ACCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_472B783ACCFA12B8 ON gallery (profile_id)');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT fk_c53d045ff675f31b');
        $this->addSql('DROP INDEX idx_c53d045ff675f31b');
        $this->addSql('ALTER TABLE image RENAME COLUMN author_id TO profile_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C53D045FCCFA12B8 ON image (profile_id)');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT fk_389b783f675f31b');
        $this->addSql('DROP INDEX idx_389b783f675f31b');
        $this->addSql('ALTER TABLE tag RENAME COLUMN author_id TO profile_id');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_389B783CCFA12B8 ON tag (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CCCFA12B8');
        $this->addSql('DROP INDEX IDX_9474526CCCFA12B8');
        $this->addSql('ALTER TABLE comment RENAME COLUMN profile_id TO author_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526cf675f31b FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9474526cf675f31b ON comment (author_id)');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT FK_389B783CCFA12B8');
        $this->addSql('DROP INDEX IDX_389B783CCFA12B8');
        $this->addSql('ALTER TABLE tag RENAME COLUMN profile_id TO author_id');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT fk_389b783f675f31b FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_389b783f675f31b ON tag (author_id)');
        $this->addSql('ALTER TABLE gallery DROP CONSTRAINT FK_472B783ACCFA12B8');
        $this->addSql('DROP INDEX IDX_472B783ACCFA12B8');
        $this->addSql('ALTER TABLE gallery RENAME COLUMN profile_id TO author_id');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT fk_472b783af675f31b FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_472b783af675f31b ON gallery (author_id)');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045FCCFA12B8');
        $this->addSql('DROP INDEX IDX_C53D045FCCFA12B8');
        $this->addSql('ALTER TABLE image RENAME COLUMN profile_id TO author_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT fk_c53d045ff675f31b FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c53d045ff675f31b ON image (author_id)');
    }
}
