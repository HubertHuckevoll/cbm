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

  /**
   * Summary of search
   * @param string $term
   * @return array
   * ________________________________________________________________
   */
  public function search(string $term): array
  {
    $data = [];
    $result = [];
    $term = mb_strtolower($term);

    foreach($this->indexData as $articleEntry)
    {
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
              'article' => $data,
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
   * ________________________________________________________________
   */
  protected function extractHit(string $text, string $searchStr, int $pos): string
  {
    $start = ($pos - 75 > 0) ? $pos - 75 : 0;
    $hit = mb_substr($text, $start, (mb_strlen($searchStr) + 150));
    $hit = '...'.$hit.'...';

    return $hit;
  }

}

?>