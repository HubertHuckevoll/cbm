<?php

class cbmArticleFolderReaderM
{
  protected string $store = '';
  protected string $articleBox = '';

  /**
   * Konstruktor
   * ________________________________________________________________
   */
  public function __construct(string $store, string $articleBox)
  {
    $this->store = $store;
    $this->articleBox = $articleBox;
  }

  /**
   * fetch Articles and sort them in descending order by date
   * _________________________________________________________________
   */
  public function get(): array
  {
    $items = [];
    $data = [];
    $result = [];
    $folder = $_SERVER['DOCUMENT_ROOT'].'/'.$this->store.'/'.$this->articleBox;

    try
    {
      if (file_exists($folder))
      {
        $items = scandir($folder);
        $items = array_diff($items, ['..', '.']);

        foreach($items as $fname)
        {
          if ($this->getFileExtension($fname) == 'htmlf')
          {
            $data = [];
            $data = $this->parseFilename($fname);
            if ($data !== false) array_push($result, $data);
          }
        }

        $sortKeyArr = array_column($result, 'date');
        array_multisort($sortKeyArr, SORT_DESC, $result);
      }

      return $result;
    }
    catch (Throwable $e)
    {
      throw new Exception('Couldn\'t read contens of folder "'.$folder.'"');
    }
  }

  /**
   * Summary of getFileExtension
   * @param mixed $fname
   * @return array|string
   * ________________________________________________________________
   */
  protected function getFileExtension(string $fname): string
  {
    return strtolower(pathinfo($fname, PATHINFO_EXTENSION));
  }

  /**
   * parse the filename into date, articleName and tags
   * ________________________________________________________________
   */
  protected function parseFilename(string $fname): bool|array
  {
    //$str = '2023-03-15_schneeammer_eule[was,zumfick].htmlf';
    $data = [];
    $matches = [];
    $re = '/(([[:digit:]]{4}-[[:digit:]]{2}-[[:digit:]]{2})_[0-9a-zäöüÄÖÜ\_\-]*\[?([[:alnum:],]*)\]?).htmlf/m';

    if (preg_match_all($re, $fname, $matches, PREG_SET_ORDER, 0) !== false)
    {
      $matches = $matches[0];
      $data['articleName'] = strtolower($matches[1]);
      $data['date'] = strtotime($matches[2].'T00:00:00');
      $data['tags'] = ($matches[3] != '') ? array_map('trim', explode(',', $matches[3])) : null;

      return $data;
    }

    return false;
  }
}

?>