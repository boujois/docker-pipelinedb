<?php
namespace PipelineDB;

class Info extends Generic{

  public function render(){
    $raw_markdown=file_get_contents("md/info.md");
    $formatted_markdown=$this->parsedown->text($raw_markdown);
    $template = $this->twig->load('markdown.html');
    return $template->render([
      'markdown'=>$formatted_markdown,
      'title'=>'PipelineDB Information'
    ]);
  }
}
