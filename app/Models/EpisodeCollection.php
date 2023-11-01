<?php

namespace App\Models;


class EpisodeCollection
{
    private array $episodes = [];

    public function add(Episode $episodes): void
    {
        $this->episodes[] = $episodes;
    }

    public function getArticles(): array
    {
        return $this->episodes;
    }

    public function findByEpisode(string $episodeNumber): int
    {
        foreach ($this->episodes as $episode) {
            if ($episode->getEpisode() === $episodeNumber) {
                return $episode->getId();
            }

        }
        return 1;
    }
}