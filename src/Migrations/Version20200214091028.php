<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200214091028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, question VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_batch (question_id INT NOT NULL, batch_id INT NOT NULL, INDEX IDX_C8E043D01E27F6BF (question_id), INDEX IDX_C8E043D0F39EBE7A (batch_id), PRIMARY KEY(question_id, batch_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, answer VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, score INT DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batch (id INT AUTO_INCREMENT NOT NULL, good_answer_id INT NOT NULL, INDEX IDX_F80B52D4AFC6C4EA (good_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batch_answer (batch_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_9262C55F39EBE7A (batch_id), INDEX IDX_9262C55AA334807 (answer_id), PRIMARY KEY(batch_id, answer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE question_batch ADD CONSTRAINT FK_C8E043D01E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_batch ADD CONSTRAINT FK_C8E043D0F39EBE7A FOREIGN KEY (batch_id) REFERENCES batch (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE batch ADD CONSTRAINT FK_F80B52D4AFC6C4EA FOREIGN KEY (good_answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE batch_answer ADD CONSTRAINT FK_9262C55F39EBE7A FOREIGN KEY (batch_id) REFERENCES batch (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE batch_answer ADD CONSTRAINT FK_9262C55AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_batch DROP FOREIGN KEY FK_C8E043D01E27F6BF');
        $this->addSql('ALTER TABLE batch DROP FOREIGN KEY FK_F80B52D4AFC6C4EA');
        $this->addSql('ALTER TABLE batch_answer DROP FOREIGN KEY FK_9262C55AA334807');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E59027487');
        $this->addSql('ALTER TABLE question_batch DROP FOREIGN KEY FK_C8E043D0F39EBE7A');
        $this->addSql('ALTER TABLE batch_answer DROP FOREIGN KEY FK_9262C55F39EBE7A');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_batch');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE batch');
        $this->addSql('DROP TABLE batch_answer');
    }
}
