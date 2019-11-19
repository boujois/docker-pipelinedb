<?php
namespace PipelineDB;

class Homepage extends Generic{

  public function render(){
    $template = $this->twig->load('homepage.html');
    $navigation=[
      ["href"=>"/info","caption"=>"Information / Usage"],
      ["href"=>"/dbstats","caption"=>"DB Stats"]
    ];
    return $template->render([
      'title'=>'PipelineDB Docker Demo',
      'heading'=>'PipelineDB Docker Demo',
      'navigation'=>$navigation
    ]);
  }
}
