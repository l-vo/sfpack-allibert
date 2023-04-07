<?php

namespace App\Event;

use App\Entity\Movie;
use Symfony\Contracts\EventDispatcher\Event;

final class MoviePageViewedEvent extends Event
{
    public function __construct(public readonly Movie $movie)
    {
    }
}