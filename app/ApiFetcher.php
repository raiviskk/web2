<?php

namespace App;


use App\Models\Character;
use App\Models\CharacterCollection;
use App\Models\Episode;
use App\Models\EpisodeCollection;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ApiFetcher
{
    private Client $client;
    private const API_URL = 'https://rickandmortyapi.com/api/episode';

    public function __construct()
    {
        $this->client =new Client();
    }

    public function fetchEpisodesFromApi(): EpisodeCollection
    {
        $response = $this->client->get(self::API_URL);
        $data = json_decode($response->getBody());

        $collection = new EpisodeCollection();

        foreach ($data->results as $result) {
            $id = $result->id;
            $name = $result->name;
            $air_date = Carbon::parse($result->air_date);
            $episode = $result->episode;

            $collection->add(new Episode($id, $name, $air_date, $episode));
        }

        return $collection;
    }
    public function fetchEpisodebyID(int $id): Episode
    {
        $episodeResponse = $this->client->get(self::API_URL . "/{$id}");
        $episodeData = json_decode((string)$episodeResponse->getBody());

        $episode = new Episode(
            $episodeData->id,
            $episodeData->name,
            Carbon::parse($episodeData->air_date),
            $episodeData->episode
        );

        $characterCollection = new CharacterCollection();
        foreach ($episodeData->characters as $characterUrl) {
            $characterResponse = $this->client->get($characterUrl);
            $characterData = json_decode((string)$characterResponse->getBody());

            $character = new Character(
                $characterData->name,
                $characterData->species,
                $characterData->gender,
                $characterData->origin->name,
                $characterData->image
            );

            $characterCollection->add($character);
        }

        $episode->setCharacters($characterCollection);

        return $episode;
    }



}

