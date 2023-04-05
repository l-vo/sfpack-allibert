<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = (new Movie())
            ->setTitle('Super Mario Bros, le film')
            ->setReleasedAt(new \DateTimeImmutable('2023-04-05'))
            ->addGenre($this->getReference('genre_action'))
            ->addGenre($this->getReference('genre_adventure'))
            ->setPoster('mario.jpg')
            ->setCountry('US')
            ->setPrice(1500)
        ;
        $manager->persist($movie);

        $movie = (new Movie())
            ->setTitle('Mon chat et moi, la grande aventure de Rroû')
            ->setReleasedAt(new \DateTimeImmutable('2023-04-05'))
            ->addGenre($this->getReference('genre_family'))
            ->addGenre($this->getReference('genre_adventure'))
            ->setPoster('chat.jpg')
            ->setCountry('FR')
            ->setPrice(2099)
        ;
        $manager->persist($movie);

        $movie = (new Movie())
            ->setTitle('Miracles')
            ->setReleasedAt(new \DateTimeImmutable('2023-04-10'))
            ->addGenre($this->getReference('genre_documentary'))
            ->setPoster('miracles.webp')
            ->setCountry('GB')
            ->setPrice(2350)
        ;
        $manager->persist($movie);

        $movie = (new Movie())
            ->setTitle('Les Ames soeurs')
            ->setReleasedAt(new \DateTimeImmutable('2023-04-12'))
            ->addGenre($this->getReference('genre_drama'))
            ->setPoster('ames.jpg')
            ->setCountry('FR')
            ->setPrice(1950)
        ;
        $manager->persist($movie);

        $manager->flush();
    }
}
