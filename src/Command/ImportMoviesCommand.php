<?php

namespace App\Command;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Omdb\OmdbApiConsumer;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:movies',
    description: 'Import movies',
)]
class ImportMoviesCommand extends Command
{
    public function __construct(
        private OmdbApiConsumer $omdbApiConsumer,
        private MovieRepository $movieRepository,
        private GenreRepository $genreRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id_or_title', InputArgument::IS_ARRAY|InputArgument::REQUIRED, 'Id or title of the movie')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $idOrTitles = $input->getArgument('id_or_title');

        $insertedData = [];
        foreach ($idOrTitles as $idOrTitle) {
            $inserted = $this->processTitleOrId($idOrTitle, $io, $input->isInteractive());
            if ($inserted === null) {
                continue;
            }
            $insertedData[] = $inserted;
        }

        $io->table(
            ['title', 'released', 'price', 'country', 'rated'],
            $insertedData,
        );

        return Command::SUCCESS;
    }

    private function processTitleOrId(string $idOrTitle, SymfonyStyle $io, bool $isInteractive): ?array
    {
        $data = $this->omdbApiConsumer->findMovie($idOrTitle);

        if ($data === null) {
            if (!$isInteractive) {
                $io->warning(sprintf('Movie %s not found and search can\'t be processed in non-interactive mode', $idOrTitle));

                return null;
            }

            $data = $this->searchMovie($idOrTitle, $io);
        }

        if ($data === null) {
            $io->warning(sprintf('Movie %s not found or too many results', $idOrTitle));

            return null;
        }

        $movie = new Movie();

        $genreNames = explode(',', $data['Genre']);
        foreach ($genreNames as $genreName) {
            $genreName = trim($genreName);
            $genre = $this->genreRepository->findOneByName($genreName);
            if ($genre === null) {
                $genre = new Genre();
                $genre->setName($genreName);

                $this->genreRepository->save($genre);
            }
            $movie->addGenre($genre);
        }

        $movie->setTitle($data['Title']);
        $movie->setReleasedAt(new \DateTimeImmutable($data['Released']));
        $movie->setPoster($data['Poster']);
        $movie->setPrice(random_int(100, 300) * 10);
        $movie->setCountry($data['Country']);
        $movie->setRated($data['Rated']);

        $this->movieRepository->save($movie, true);

        return [
            $movie->getTitle(),
            $movie->getReleasedAt()->format('Y-m-d'),
            $movie->getPrice(),
            $movie->getCountry(),
            $movie->getRated(),
        ];
    }

    private function searchMovie(string $idOrTitle, SymfonyStyle $io): ?array
    {
        $manyResults = $this->omdbApiConsumer->searchMovie($idOrTitle);
        if ($manyResults === null) {
            return null;
        }

        if (count($manyResults) === 1) {
            $id = $manyResults[0]['imdbID'];
        } else {
            $titles = [];
            $idsByTitle = [];
            foreach ($manyResults as $movieData) {
                $titles[] = $movieData['Title'];
                $idsByTitle[$movieData['Title']] = $movieData['imdbID'];
            }

            $key = $io->choice('Which movie do you want to import ?', $titles);
            $id = $idsByTitle[$key];
        }

        $movieData = $this->omdbApiConsumer->findMovie($id);

        if ($movieData === null) {
            $io->warning(sprintf('Unexpected problem retrieving %s', $idOrTitle));
        }

        return $movieData;
    }
}
