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

    public function searchFilter(string $search): int
    {
        foreach ($this->episodes as $episode) {
            if ($episode->getEpisode() === $search) {
                return $episode->getId();
            }
            if ($episode->getName() === $search) {
                return $episode->getId();}


        }
        return 1;
    }
}