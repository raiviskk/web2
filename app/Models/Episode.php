<?php

namespace App\Models;

use Carbon\Carbon;

class Episode
{
    private $id;
    private string $name;
    private Carbon $airDate;
    private string $episode;

    private ?CharacterCollection $characters;


    public function __construct
    (
        $id,
        string $name,
        Carbon $airDate,
        string $episode,
        ?CharacterCollection $characters = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->episode = $episode;
        $this->characters = $characters;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getAirDate(): Carbon
    {
        return $this->airDate;
    }


    public function getEpisode():string
    {
        return $this->episode;
    }

    /**
     * @return CharacterCollection|null
     */
    public function getCharacters(): ?CharacterCollection
    {
        return $this->characters;
    }

    /**
     * @param CharacterCollection|null $characters
     */
    public function setCharacters(?CharacterCollection $characters): void
    {
        $this->characters = $characters;
    }


}




