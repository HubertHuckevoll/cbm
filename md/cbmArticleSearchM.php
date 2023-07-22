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
    $result = [];
    $term = mb_strtolower($term);

    foreach($this->indexData as $articleEntry)
    {
      $artObj = new cbmXmlM($articleEntry['store'], $articleEntry['articleBox'], $articleEntry['articleName']);
      $article = $artObj->get();

      foreach($article as $key => $val)
      {
        if ($key == 'xml')
        {
          $sxi = new SimpleXMLIterator($article['xml']->asXML());
          $ret = $this->searchArticle($sxi, $article, $term);
          if ($ret) {
            array_push($result, $ret);
            break; // one hit per article is enough
          }
        }
        else
        {
          $ret = $this->findElement($article, $val, $term);
          if ($ret) {
            array_push($result, $ret);
            break; // one hit per article is enough
          }
        }
      }
    }

    return $result;
  }

  private function searchArticle(SimpleXMLIterator $sxi, array $article, string $term): ?array
  {
    for($sxi->rewind(); $sxi->valid(); $sxi->next())
    {
      if ($sxi->hasChildren())
      {
        $this->searchArticle($sxi->current(), $article, $term);
      }
      else
      {
        $val = $sxi->current();
        $ret = $this->findElement($article, $val, $term);
        if ($ret) return $ret;
      }
    }

    return null;
  }

  protected function findElement(array $article, string $haystack, string $needle): ?array
  {
    $haystack = mb_strtolower($haystack);
    $haystack = strip_tags($haystack);
    if (($pos = mb_stripos($haystack, $needle)) !== false)
    {
      $hit = $this->extractHit($haystack, $needle, $pos);
      return [
        'article' => $article,
        'hit' => $hit
      ];
    }

    return null;
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
    $hit = str_ireplace($searchStr, '<strong>'.$searchStr.'</strong>', $hit);

    return $hit;
  }

}

?>