<?php

class cbmArticleFolderReaderM
{
  protected string $store = '';
  protected string $articleBox = '';

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

        foreach($items as $articleName)
        {
          $data = [];
          $data['date'] = $this->extractDateFromFilename($articleName);
          $data['articleName'] = $this->removeFileExtension($articleName);
          array_push($result, $data);
        }

        $sortKeyArr = array_column($result, 'date');
        array_multisort($sortKeyArr, SORT_DESC, $result);
      }

      $result = [
        'meta' => ['articleBox' => $this->articleBox],
        'articles' => $result
      ];

      return $result;
    }
    catch (Exception $e)
    {
      throw new Exception('Couldn\'t read contens of folder "'.$folder.'"');
    }
  }

  /**
   * remove file extension
   * ________________________________________________________________
   */
  protected function removeFileExtension(string $fname): string
  {
    return pathinfo($fname, PATHINFO_FILENAME);
  }

  /**
   * fetch date
   * ___________________________________________________________________
   */
  protected function extractDateFromFilename(string $fname): int
  {
    $dateStr = substr($fname, 0, 10).'T00:00:00'; // 2023-09-01 = 10 characters
    $dateStamp = strtotime($dateStr);

    return $dateStamp;
  }
}

?>