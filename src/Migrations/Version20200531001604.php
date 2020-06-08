<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200531001604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE comments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comments (id INT NOT NULL, poster_id INT NOT NULL, text_comment TEXT NOT NULL, date_comment TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F9E962A5BB66C05 ON comments (poster_id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A5BB66C05 FOREIGN KEY (poster_id) REFERENCES posters (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE posters ALTER count_view SET NOT NULL');
        $this->addSql('ALTER INDEX idx_48902d37af05962b RENAME TO IDX_48902D37A76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comments_id_seq CASCADE');
        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE posters ALTER count_view DROP NOT NULL');
        $this->addSql('ALTER INDEX idx_48902d37a76ed395 RENAME TO idx_48902d37af05962b');
    }
}
