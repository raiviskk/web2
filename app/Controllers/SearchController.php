<?php

namespace App\Controllers;

use App\ApiFetcher;
use App\Response;


class SearchController
{
    private ApiFetcher $api;

    public function __construct()
    {
        $this->api = new ApiFetcher();
    }

    public function index(): Response
    {
        $queryParameters = $_GET;
        $search = (string)$queryParameters['search'];
        $data = $this->api->fetchEpisodesFromApi();
        $episodeID = $data->searchFilter($search);
        $episode = $this->api->fetchEpisodebyID($episodeID);
        $template = 'episodes/show';
        $data = ['episode' => $episode];
        return new Response($template, $data);

    }

}

