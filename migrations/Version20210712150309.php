<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712150309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE line_purchase (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, purchase_id INT NOT NULL, quantity INT NOT NULL, total INT NOT NULL, INDEX IDX_B27481414584665A (product_id), INDEX IDX_B2748141558FBEB9 (purchase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, date DATE NOT NULL, total INT NOT NULL, INDEX IDX_6117D13B9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_purchase ADD CONSTRAINT FK_B27481414584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE line_purchase ADD CONSTRAINT FK_B2748141558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_purchase DROP FOREIGN KEY FK_B2748141558FBEB9');
        $this->addSql('DROP TABLE line_purchase');
        $this->addSql('DROP TABLE purchase');
    }
}
