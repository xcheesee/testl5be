<?php
namespace Src\Controllers;

class FilmController {

    private $db;
    private $requestMethod;
    private $filmId;

    public function __construct($db, $requestMethod, $filmId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->filmId = $filmId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->filmId) {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://swapi.dev/api/films/" . $this->filmId);
                    $response = curl_exec($curl);
                } else {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://swapi.dev/api/films");
                    $response = curl_exec($curl);
                };
                break;
        }
        //header($response['status_code_header']);
        return $response;
    }
}
