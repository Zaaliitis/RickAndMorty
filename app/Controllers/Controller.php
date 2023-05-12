<?php

namespace App\Controllers;

use App\ApiClient;
use App\Core\View;

class Controller
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function home(): View
    {
        $page = $_GET['page'] ?? 1;
        $characters = $this->client->getCharacters($page);

        $content = array_merge(
            $this->getCommonData(),
            [
                'characters' => $characters,
                'page' => $page,
            ]
        );

        return new View("characters", $content);
    }

    public function character(): View
    {
        $id = $_GET['id'] ?? null;
        $character = $this->client->getCharacter($id);

        $content = array_merge(
            $this->getCommonData(),
            [
                'character' => $character,
                'id' => $id,
            ]
        );

        return new View("character", $content);
    }

    public function search(): View
    {
        $name = $_GET['name'] ?? '';
        $page = $_GET['page'] ?? 1;
        $characters = $this->client->getCharactersByName($name, $page);

        $content = array_merge(
            $this->getCommonData(),
            [
                'characters' => $characters,
                'name' => $name,
                'page' => $page,
            ]
        );

        return new View("characters", $content);
    }

    public function episode(): View
    {
        $id = $_GET['id'] ?? 1;
        $episode = $this->client->getEpisode($id);

        $content = array_merge(
            $this->getCommonData(),
            [
                'episode' => $episode,
                'id' => $id,
            ]
        );

        return new View("episode", $content);
    }

    public function location(): View
    {
        $id = $_GET['id'] ?? 1;
        $location = $this->client->getLocation($id);

        $content = array_merge(
            $this->getCommonData(),
            [
                'location' => $location,
                'id' => $id,
            ]
        );

        return new View("location", $content);
    }

    private function getCommonData(): array
    {
        $locations = $this->client->getLocations();
        $episodes = $this->client->getEpisodes();

        return [
            'locations' => $locations,
            'episodes' => $episodes,
        ];
    }
}
