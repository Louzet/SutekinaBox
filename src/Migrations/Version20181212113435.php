<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181212113435 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE box (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, description VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, date_livraison DATETIME NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE box_product (box_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CA889A9CD8177B3F (box_id), INDEX IDX_CA889A9C4584665A (product_id), PRIMARY KEY(box_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE box_product ADD CONSTRAINT FK_CA889A9CD8177B3F FOREIGN KEY (box_id) REFERENCES box (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE box_product ADD CONSTRAINT FK_CA889A9C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE box_product DROP FOREIGN KEY FK_CA889A9CD8177B3F');
        $this->addSql('DROP TABLE box');
        $this->addSql('DROP TABLE box_product');
    }
}
