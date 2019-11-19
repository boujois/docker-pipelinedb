<?php
namespace PipelineDB;

class Info{
  private $parsedown;

  public function __construct($container){
    $this->setParsedown($container["parsedown"]);
  }

  public function setParsedown($parsedown){
    $this->parsedown=$parsedown;
  }

  public function render(){
    $response='
    <html>
    <head>
    <title>PipelineDB Information</title>
    <link rel="stylesheet" type="text/css" href="css/markdown.css"/>
    <link rel="stylesheet" type="text/css" href="css/tables.css"/>
    </head>
    <body class="markdown-body">
    ';
    $markdown=file_get_contents("md/info.md");
    $response.=$this->parsedown->text($markdown);
    $response.='
    </body>
    </html>
    ';
    return $response;
  }
}
