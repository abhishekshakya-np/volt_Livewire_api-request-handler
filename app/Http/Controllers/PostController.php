<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|null
     * @throws GuzzleException
     */
    public function getPost(): \Illuminate\Foundation\Application|View|Factory|Application|null
    {
        // No API key needed for json placeholder
        $apiKey = '';

        // Create a new Guzzle client instance
        $client = new Client();

        // API endpoint URL for json placeholder
        $apiUrl = "https://jsonplaceholder.typicode.com/posts";

        try {
            // Make a GET request to the json placeholder API
            $response = $client->get($apiUrl);

            // Get the response body as an array
            $data = json_decode($response->getBody(), true);

            // Handle the retrieved post-data as needed (e.g., pass it to a view)
            return view('post', ['postData' => $data]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }

}
