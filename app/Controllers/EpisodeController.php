<?php

namespace App\Controllers;

use App\ApiFetcher;
use App\Response;


class EpisodeController
{
    private ApiFetcher $api;

    public function __construct()
    {
        $this->api = new ApiFetcher();
    }

    public function index(): Response
    {
        $data = $this->api->fetchEpisodesFromApi();
        $template = 'episodes/index';
        $data = ['episodes' => $data->getArticles()];
        return new Response($template, $data);
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];
        $episode = $this->api->fetchEpisodebyID($id);
        $template = 'episodes/show';
        $episode = ['episode' => $episode];
        return new Response($template, $episode);
    }

    public function search(): Response
    {
        $queryParameters = $_GET;
        $id = (string)$queryParameters['episode'];
        $data = $this->api->fetchEpisodesFromApi();
        $episodeID = $data->findByEpisode($id);
        $episode = $this->api->fetchEpisodebyID($episodeID);
        $template = 'episodes/show';
        $data = ['episode' => $episode];
        return new Response($template, $data);

    }

}

