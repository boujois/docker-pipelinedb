<?php
namespace PipelineDB;

class DBStats extends Generic{

  public function render(){
    $continuous_views=[];
    $result = $this->pdo->query("SELECT * from pipelinedb.views;");
    while ($row = $result->fetch()){
      $continuous_views[]=$row;
    }

    $template = $this->twig->load('dbstats.html');
    return $template->render([
      'title'=>'PipelineDB DB Stats',
      'heading'=>'PipelineDB Stats',
      'continuous_views'=>$continuous_views
    ]);
  }
}
