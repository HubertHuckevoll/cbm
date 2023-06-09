<?php

class cbmArticleFolderReaderM
{
  protected string $store = '';
  protected string $articleBox = '';
  protected array $allTags = [];
  protected array $entries = [];

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
  public function read(): void
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
            $data = $this->createEntry($fname);
            if ($data !== false) array_push($result, $data);
          }
        }

        $sortKeyArr = array_column($result, 'date');
        array_multisort($sortKeyArr, SORT_DESC, $result);
      }

      $this->entries = $result;
    }
    catch (Throwable $e)
    {
      throw new Exception('Couldn\'t read contens of folder "'.$folder.'"');
    }
  }

  /**
   * Summary of get
   * @param mixed $tags
   * @return array
   * ________________________________________________________________
   */
  public function get(string $tags = ''): array
  {
    $result = [];

    if ($tags == '') return $this->entries;

    $tags = array_map('trim', explode(',', $tags));

    for($i=0; $i < count($this->entries); $i++)
    {
      if (count(array_intersect($tags, $this->entries[$i]['tags'])) > 0)
      {
        array_push($result, $this->entries[$i]);
      }
    }

    return $result;
  }

  /**
   * Summary of getRandom
   * @param mixed $numElements
   * @return array
   * ________________________________________________________________
   */
  public function getRandom(string $tags, int $numElements): array
  {
    $result = [];
    $entries = $this->get($tags);
  	$artNum = count($entries) - 1;
    $numElements = ($numElements > $artNum) ? $artNum : $numElements;

  	while(count($result) < $numElements)
  	{
  		$x = random_int(0, $artNum);
      array_push($result, $this->entries[$x]);
      $result = array_unique($result, SORT_REGULAR);
      $result = array_values($result);
  	}

    return $result;
  }

  /**
   * get all the tags
   * ________________________________________________________________
   */
  public function getAllTags(): array
  {
    return $this->allTags;
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
  protected function createEntry(string $fname): bool|array
  {
    //$str = '2023-03-15_schneeammer_eule[was,zumfick].htmlf';
    $data = [];
    $matches = [];
    $re = '/(([[:digit:]]{4}-[[:digit:]]{2}-[[:digit:]]{2})_[0-9a-zäöüÄÖÜ\_\-]*\[?([[:alnum:],]*)\]?).htmlf/m';

    if (preg_match_all($re, $fname, $matches, PREG_SET_ORDER, 0) !== false)
    {
      $matches = $matches[0];
      $data['store'] = $this->store;
      $data['articleBox'] = $this->articleBox;
      $data['articleName'] = strtolower($matches[1]);
      $data['date'] = strtotime($matches[2].'T00:00:00');
      $data['tags'] = ($matches[3] != '') ? array_map('trim', explode(',', $matches[3])) : [];

      $this->allTags = array_merge($this->allTags, $data['tags']);
      $this->allTags = array_filter($this->allTags);
      $this->allTags = array_unique($this->allTags);

      return $data;
    }

    return false;
  }
}

?>