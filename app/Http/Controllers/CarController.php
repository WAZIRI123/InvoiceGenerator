<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use GuzzleHttp\Client;

class CarController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sortDependenciesByStars($repoName)
    {
        $response = $this->client->get("https://api.github.com/repos/$repoName/network/dependents");

        if ($response->getStatusCode() === 200) {
            $dependents = json_decode($response->getBody(), true);

            $sortedDependents = usort($dependents, function ($a, $b) {
                return $b['stargazers_count'] - $a['stargazers_count'];
            });

            return $sortedDependents;
        } else {
            throw new \Exception('Failed to retrieve dependents');
        }
    }
}
