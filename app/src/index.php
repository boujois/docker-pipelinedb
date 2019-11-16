<?php

chdir(dirname(__FILE__));
require_once('lib/parsedown.php');
$Parsedown = new Parsedown();

//require_once('lib/class.print_queue.php');
// $pq=new printQueue();
// if($pq->isInstalled()==false){
//   $pq->install();
//   die;
// }

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$method=strtolower($_SERVER['REQUEST_METHOD']);

if(strlen($request_uri[0])>1 && substr($request_uri[0],-1)=="/"){
  $request_uri[0]=substr($request_uri[0],0,-1);
}

// GET
if($method=="get"){
  switch ($request_uri[0]) {

    case '/':
    require 'views/home.php';
    break;

    case '/dbstats':
    require 'views/dbstats.php';
    break;

    case '/info':
    require 'views/info.php';
    break;

    case '/webshell':
    require 'views/webshell.php';
    break;

    default:
    require 'views/404.php';
    break;
  }
}

// POST
if($method=="post"){
  switch ($request_uri[0]) {

    case '/webshell':
    require 'views/webshell.php';
    break;

    default:
    require 'views/404.php';
    break;
  }
}
