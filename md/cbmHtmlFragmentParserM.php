<?php

class cbmHtmlFragmentParserM
{
  protected string $fileContent = '';

  public function __construct(string $fc)
  {
    $this->fileContent = $fc;
  }

  public function parse(): array
  {
    $result = [];
    $re = '/<cbm-(.*)>(.*)<\/cbm-\1>/iuUs';

    preg_match_all($re, $this->fileContent, $result, PREG_SET_ORDER, 0);

    $result = array_column($result, 2, 1);

    foreach($result as $tag => &$val)
    {
      $val = $this->exec($tag, $val);
    }

    return $result;
  }

  protected function gallery(string $tagVal): array
  {
    $result = [];
    $re = '/<li>(.*)<\/li>/m';

    preg_match_all($re, $tagVal, $result, PREG_SET_ORDER, 0);

    $result = array_column($result, 1);

    return $result;
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

}

?>