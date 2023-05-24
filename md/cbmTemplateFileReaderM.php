<?php

class cbmTemplateFileReaderM
{
  protected string $templName = '';
  protected string $localViewFolder = './vw/';

  public function __construct(string $templName)
  {
    $this->templName = $templName;
  }

  public function get(): string
  {
    $fname = $this->localViewFolder.$this->templName.'.htmlt';
    $fc = file_get_contents($fname);

    if ($fc !== false)
    {
      return $fc;
    }
    else
    {
      throw new Exception('Can\'t read file "'.$fname.'"');
    }
  }

}

?>