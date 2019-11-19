<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$pdo = new PDO('pgsql:host=pipelinedb;dbname=postgres', 'postgres', 'pipelinedb123');
$parsedown = new Parsedown();

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => '/tmp',
    'auto_reload' => true
]);


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
$container['twig'] = $twig;

$app->get('/', function (Request $request, Response $response, array $args) {
  require 'views/home.php';
});
$app->get('/dbstats', function (Request $request, Response $response, array $args) {
  require 'views/dbstats.php';
});

$app->get('/info', function (Request $request, Response $response, array $args) {
  $info=new \PipelineDB\Info($this);
  echo $info->render();
});


$app->run();
