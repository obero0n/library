<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212094155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE library ADD user_id INT NOT NULL, ADD book_id INT NOT NULL');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_A18098BCA76ED395 ON library (user_id)');
        $this->addSql('CREATE INDEX IDX_A18098BC16A2B381 ON library (book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BCA76ED395');
        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BC16A2B381');
        $this->addSql('DROP INDEX IDX_A18098BCA76ED395 ON library');
        $this->addSql('DROP INDEX IDX_A18098BC16A2B381 ON library');
        $this->addSql('ALTER TABLE library DROP user_id, DROP book_id');
    }
}
