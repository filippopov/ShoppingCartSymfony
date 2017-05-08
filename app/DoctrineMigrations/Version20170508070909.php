<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170508070909 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD promotion_price NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE promotions ADD promotion_name VARCHAR(255) NOT NULL, ADD full_promotion SMALLINT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA1B3034E8D9F699 ON promotions (promotion_name)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP promotion_price');
        $this->addSql('DROP INDEX UNIQ_EA1B3034E8D9F699 ON promotions');
        $this->addSql('ALTER TABLE promotions DROP promotion_name, DROP full_promotion');
    }
}
