<?php

class cbmTemplateFileReaderM
{
  protected string $templName = '';

  public function __construct(string $templName)
  {
    $this->templName = $templName;
  }

  public function get(): string
  {
    $fname = './vw/'.$this->templName.'.htmlt';
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