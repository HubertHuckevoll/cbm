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

    return $result;
  }

}

?>