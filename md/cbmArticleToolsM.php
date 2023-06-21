<?php

trait cbmArticleToolsM
{
  /**
   * parse the filename into date, articleName and tags
   * ________________________________________________________________
   */
  protected function parseFilename(string $fname): bool|array
  {
    //$str = '2023-03-15_schneeammer-eule_urlaub-birb-jadebusen.xml';
    $data = [];
    $matches = [];
    $re = '/(([[:digit:]]{4}-[[:digit:]]{2}-[[:digit:]]{2})_([0-9a-z\-]*)_?([[:alnum:]-]*)?).xml$/m';

    if (preg_match_all($re, $fname, $matches, PREG_SET_ORDER, 0) !== false)
    {
      $matches = $matches[0];
      $data['articleName'] = $matches[1];
      $data['date'] = strtotime($matches[2].'T00:00:00');
      $data['tags'] = ($matches[3] != '') ? array_map('trim', explode('-', $matches[3])) : [];

      return $data;
    }

    return false;
  }

}

?>