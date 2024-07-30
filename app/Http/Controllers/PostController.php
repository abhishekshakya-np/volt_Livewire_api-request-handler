<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PostController extends Controller
{
    public function getPost()
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
            return $this->view('post', ['postData' => $data]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }

    private function view(string $string, array $array)
    {
    }
}
