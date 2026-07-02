<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701134227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking DROP CONSTRAINT fk_d3e9dccd4431a71b');
        $this->addSql('DROP INDEX idx_d3e9dccd4431a71b');
        $this->addSql('ALTER TABLE clocking DROP duration');
        $this->addSql('ALTER TABLE clocking DROP clocking_project_id');
        $this->addSql('ALTER TABLE clocking_item ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE clocking_item DROP project');
        $this->addSql('ALTER TABLE clocking_item ADD CONSTRAINT FK_331F02BD166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_331F02BD166D1F9C ON clocking_item (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking ADD duration INT NOT NULL');
        $this->addSql('ALTER TABLE clocking ADD clocking_project_id INT NOT NULL');
        $this->addSql('ALTER TABLE clocking ADD CONSTRAINT fk_d3e9dccd4431a71b FOREIGN KEY (clocking_project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d3e9dccd4431a71b ON clocking (clocking_project_id)');
        $this->addSql('ALTER TABLE clocking_item DROP CONSTRAINT FK_331F02BD166D1F9C');
        $this->addSql('DROP INDEX IDX_331F02BD166D1F9C');
        $this->addSql('ALTER TABLE clocking_item ADD project VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE clocking_item DROP project_id');
    }
}
