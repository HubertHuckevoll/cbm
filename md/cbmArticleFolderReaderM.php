<?php

class cbmArticleFolderReaderM
{
  protected string $articleBox = '';

  public function __construct(string $articleBox)
  {
    $this->articleBox = $articleBox;
  }

  /**
   * fetch Articles and sort them in descending order by date
   * _________________________________________________________________
   */
  public function get(): array
  {
    $data = array();
    $folder = $_SERVER['DOCUMENT_ROOT'].'/cbm.datastore/'.$this->articleBox;

    try
    {
      if (file_exists($folder))
      {
        $items = scandir($folder);
        $items = array_diff($items, ['..', '.']);

        foreach($items as $articleName)
        {
          $date = $this->extractDateFromFilename($articleName);
          $data[$date] = $this->removeFileExtension($articleName);
        }

        krsort($data);
        return $data;
      }

      return $items;
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