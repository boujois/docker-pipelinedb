<?php
namespace PipelineDB;

class Generic{
  protected $parsedown;
  protected $twig;
  protected $pdo;

  public function __construct($container){
    $this->setParsedown($container["parsedown"]);
    $this->setTwig($container["twig"]);
    $this->setPDO($container["pdo"]);
  }

  public function setParsedown($parsedown){
    $this->parsedown=$parsedown;
  }

  public function setTwig($twig){
    $this->twig=$twig;
  }

  public function setPDO($pdo){
    $this->pdo=$pdo;
  }

}
