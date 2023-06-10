<?php

class cbmArticleSearchM
{
  protected array $indexData = [];

  /**
   * Summary of __construct
   * @param array $indexData
   * ________________________________________________________________
   */
  public function __construct(array $indexData)
  {
    $this->indexData = $indexData;
  }

  public function search(string $term): array
  {
    $data = [];
    $result = [];
    $i = 0;

    $term = mb_strtolower($term);

    foreach($this->indexData as $articleEntry)
    {
      $data = [];
      $article = new cbmArticleM($articleEntry['store'], $articleEntry['articleBox'], $articleEntry['articleName']);
      $data = $article->get();

      foreach($data as $key => $val)
      {
        if ($key !== 'images')
        {
          $val = mb_strtolower($val);
          $val = strip_tags($val);
          if (($pos = mb_stripos($val, $term)) !== false)
          {
            $hit = $this->extractHit($val, $term, $pos);
            $hit = str_ireplace($term, '<strong>'.$term.'</strong>', $hit);
            array_push($result, [
              'article' => $article,
              'hit' => $hit
            ]);
            break; // one hit per article is enough
          }
        }
      }
    }

    return $result;
  }

  /**
   * Summary of extractHit
   * @param string $text
   * @param string $searchStr
   * @param int $pos
   * @return string
   */
  protected function extractHit(string $text, string $searchStr, int $pos): string
  {
    $start = ($pos - 75 > 0) ? $pos - 75 : 0;
    $hit = substr($text, $start, (strlen($searchStr) + 150));
    $hit = '...'.$hit.'...';

    return $hit;
  }

}

?>