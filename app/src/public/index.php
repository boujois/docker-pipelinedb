<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$pdo = new PDO('pgsql:host=pipelinedb;dbname=postgres', 'postgres', 'pipelinedb123');
$parsedown = new Parsedown();

//$app = new \Slim\App; // production

// development
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$container = $app->getContainer();
$container['db'] = $pdo;
$container['parsedown'] = $parsedown;

$app->get('/', function (Request $request, Response $response, array $args) {
  require 'views/home.php';
});
$app->get('/dbstats', function (Request $request, Response $response, array $args) {
  require 'views/dbstats.php';
});

$app->get('/info', function (Request $request, Response $response, array $args) {
  require 'views/info.php';
});


$app->run();
