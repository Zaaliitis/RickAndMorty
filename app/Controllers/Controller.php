<?php

namespace App\Controllers;

use App\ApiClient;
use App\View;

class Controller
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function characters(): View
    {
        $page = $_GET['page'] ?? 1;
        $characters = $this->client->getCharacters($page);
        return new View("characters", ['characters' => $characters, 'page' => $page]);
    }
    public function episodes(): View
    {
        $page = $_GET['page'] ?? 1;
        $episodes = $this->client->getEpisodes($page);
        return new View("episodes", ['episodes' => $episodes, 'page' => $page]);
    }
    public function locations(): View
    {
        $page = $_GET['page'] ?? 1;
        $locations = $this->client->getLocations();
        return new View("locations", ['locations' => $locations, 'page' => $page]);
    }
}