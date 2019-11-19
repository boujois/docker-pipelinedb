<?php
namespace PipelineDB;

class Generic{
  protected $parsedown;
  protected $twig;

  public function __construct($container){
    $this->setParsedown($container["parsedown"]);
    $this->setTwig($container["twig"]);
  }

  public function setParsedown($parsedown){
    $this->parsedown=$parsedown;
  }

  public function setTwig($twig){
    $this->twig=$twig;
  }

}
