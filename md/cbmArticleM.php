<?php

class cbmArticleM
{
  protected string $store = '';
  protected string $articleBox = '';
  protected string $articleName = '';
  protected $articleFile = '';

  public function __construct(string $store, string $articleBox, string $articleName)
  {
    $this->store = $store;
    $this->articleBox = $articleBox;
    $this->articleName = $articleName;
    $this->articleFile = $_SERVER['DOCUMENT_ROOT'].'/'.$this->store.'/'.$this->articleBox.'/'.$this->articleName.'.htmlf';
  }

  public function get(): array
  {
    $result = [];
    $fileContent = $this->readFile();
    $re = '/<cbm-(.*)>(.*)<\/cbm-\1>/iuUs';

    preg_match_all($re, $fileContent, $result, PREG_SET_ORDER, 0);

    $result = array_column($result, 2, 1);

    foreach($result as $tag => &$val)
    {
      $val = $this->exec($tag, $val);
    }

    return $result;
  }

  public function readFile(): string
  {
    $fc = file_get_contents($this->articleFile);
    if ($fc !== false)
    {
      return $fc;
    }
    else
    {
      throw new Exception('Can\'t read file "'.$this->articleFile.'"');
    }
  }

  /**
   * execute a parse function dynamically
   * _________________________________________________________________
   */
  public function exec(string $method, string $tagVal): mixed
  {
    if (method_exists($this, $method))
    {
      $tagVal = $this->$method($tagVal);
    }

    return $tagVal;
  }

  protected function gallery(string $tagVal): array
  {
    $result = [];
    $re = '/<li>(.*)<\/li>/m';

    preg_match_all($re, $tagVal, $result, PREG_SET_ORDER, 0);

    $result = array_column($result, 1);

    foreach ($result as &$img)
    {
      $img = '/'.$this->store.'/'.$this->articleBox.'.assets/'.$img;
    }

    return $result;
  }

}

?>