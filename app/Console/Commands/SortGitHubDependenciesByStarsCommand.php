<?php

namespace App\Console\Commands;

use App\Http\Controllers\CarController;
use Illuminate\Console\Command;

class SortGitHubDependenciesByStarsCommand extends Command
{
    protected $signature = 'sort:github-dependencies-by-stars {repoName}';

    protected $description = 'Sorts GitHub dependencies by most starred';

    public function handle()
    {
        $repoName = $this->argument('repoName');

        $githubDependenciesSorter = new CarController(new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), )));

        $sortedDependencies = $githubDependenciesSorter->sortDependenciesByStars($repoName);

        foreach ($sortedDependencies as $dependency) {
            $this->info($dependency['full_name']);
        }
    }}
