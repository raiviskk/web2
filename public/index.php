<?php

use App\ApiFetcher;
use App\Controllers\EpisodeController;
use App\Controllers\PageController;
use App\Controllers\SearchController;
use App\Response;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/../app/Views/');
$twig = new Environment($loader);

//time
$londonTime = Carbon::now('Europe/London');
$twig->addGlobal('londonTime', $londonTime);

//weather
$apiKey = 'bd4c3e9c3add39698ed3161185569a6a';
$city = 'London';
$url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey";

$response = file_get_contents($url);
$weatherData = json_decode($response, true);

if ($weatherData) {
    $temperatureKelvin = $weatherData['main']['temp'];
    $temperatureCelsius = $temperatureKelvin - 273.15;
    $weatherData['main']['temp_celsius'] = $temperatureCelsius;
    $twig->addGlobal('weatherData', $weatherData);
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/episodes', [EpisodeController::class, 'index']);
    $r->addRoute('GET', '/episode/{id:\d+}', [EpisodeController::class, 'show']);
    $r->addRoute('GET', '/search', [SearchController::class, 'index']);
    $r->addRoute('GET', '/', [PageController::class, 'index']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $vars = $routeInfo[2];
        [$controller, $method] = $routeInfo[1];

        $response = (new $controller())->{$method}($vars);

        /** @var Response $response */
        echo $twig->render($response->getViewName() . '.twig', $response->getData());
        break;
}
