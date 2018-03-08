<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180308172213 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, description, is_done, create_at FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER NOT NULL, owner_id INTEGER NOT NULL, description VARCHAR(100) NOT NULL COLLATE BINARY, is_done BOOLEAN NOT NULL, create_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_527EDB257E3C61F9 FOREIGN KEY (owner_id) REFERENCES _user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO task (id, description, is_done, create_at) SELECT id, description, is_done, create_at FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('CREATE INDEX IDX_527EDB257E3C61F9 ON task (owner_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_527EDB257E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, description, is_done, create_at FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER NOT NULL, description VARCHAR(100) NOT NULL, is_done BOOLEAN NOT NULL, create_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO task (id, description, is_done, create_at) SELECT id, description, is_done, create_at FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }
}
