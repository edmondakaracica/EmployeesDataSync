<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Mapper\EmployeeMapper;
use App\Client\TrackTikAPIClient;
use App\Controller\EmployeeController;

    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    $accessToken = $_ENV['ACCESS_TOKEN'];
    $apiUrl = $_ENV['API_URL'];

    if (!$accessToken) {
        throw new RuntimeException("Missing ACCESS_TOKEN in .env file.");
    }

    if (!$apiUrl) {
        throw new RuntimeException("Missing API_URL in .env file.");
    }

    $mapper = new EmployeeMapper();
    $apiClient = new TrackTikAPIClient($accessToken, $apiUrl);
    $controller = new EmployeeController($mapper, $apiClient);

    $controller->handleRequest();
