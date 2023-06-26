<?php

class cbmArticleFolderReaderM
{
  use cbmArticleToolsM;

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
          if ($this->getFileExtension($fname) == 'xml')
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

    $tags = array_map('trim', explode('-', $tags));

    for($i = 0; $i < count($this->entries); $i++)
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
  public function getRandom(string $tags, ?int $numElements): array
  {
    $result = [];

    if ($numElements === null) return $result;

    $entries = $this->get($tags);
    $artNum = count($entries);
    $numElements = ($numElements > $artNum) ? $artNum : $numElements;

    while(count($result) < $numElements)
    {
      $x = random_int(0, ($artNum-1));
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
  protected function createEntry(string $fname): array
  {
    $data = [];
    $data = $this->parseFilename($fname);
    $data['store'] = $this->store;
    $data['articleBox'] = $this->articleBox;
    $this->allTags = array_merge($this->allTags, $data['tags']);
    $this->allTags = array_filter($this->allTags);
    $this->allTags = array_unique($this->allTags);

    return $data;
  }
}

?>