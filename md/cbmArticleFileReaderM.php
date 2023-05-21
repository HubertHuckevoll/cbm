<?php

class cbmArticleFileReaderM
{
  protected string $articleBox = '';
  protected string $articleName = '';

  public function __construct(string $articleBox, string $articleName)
  {
    $this->articleBox = $articleBox;
    $this->articleName = $articleName;
  }

  public function get(): string
  {
    $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm.datastore/'.$this->articleBox.'/'.$this->articleName.'.htmlf';
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