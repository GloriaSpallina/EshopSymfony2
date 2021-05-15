<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515124712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD adresse_livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DBE2F0A35 FOREIGN KEY (adresse_livraison_id) REFERENCES adresse_livraison (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DBE2F0A35 ON commande (adresse_livraison_id)');
        $this->addSql('ALTER TABLE evaluation ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_1323A575F347EFB ON evaluation (produit_id)');
        $this->addSql('ALTER TABLE photo_produit ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo_produit ADD CONSTRAINT FK_1C45FBAAF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_1C45FBAAF347EFB ON photo_produit (produit_id)');
        $this->addSql('ALTER TABLE produit ADD sous_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27365BF48 ON produit (sous_categorie_id)');
        $this->addSql('ALTER TABLE sous_categorie ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_52743D7BBCF5E72D ON sous_categorie (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBE2F0A35');
        $this->addSql('DROP INDEX IDX_6EEAA67DBE2F0A35 ON commande');
        $this->addSql('ALTER TABLE commande DROP adresse_livraison_id');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575F347EFB');
        $this->addSql('DROP INDEX IDX_1323A575F347EFB ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP produit_id');
        $this->addSql('ALTER TABLE photo_produit DROP FOREIGN KEY FK_1C45FBAAF347EFB');
        $this->addSql('DROP INDEX IDX_1C45FBAAF347EFB ON photo_produit');
        $this->addSql('ALTER TABLE photo_produit DROP produit_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27365BF48');
        $this->addSql('DROP INDEX IDX_29A5EC27365BF48 ON produit');
        $this->addSql('ALTER TABLE produit DROP sous_categorie_id');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D');
        $this->addSql('DROP INDEX IDX_52743D7BBCF5E72D ON sous_categorie');
        $this->addSql('ALTER TABLE sous_categorie DROP categorie_id');
    }
}
