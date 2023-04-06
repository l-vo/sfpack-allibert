<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230406132400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add rated column';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movie ADD COLUMN rated VARCHAR(3) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, poster, country, released_at, price FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(150) NOT NULL, poster VARCHAR(80) NOT NULL, country VARCHAR(2) NOT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO movie (id, title, poster, country, released_at, price) SELECT id, title, poster, country, released_at, price FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
