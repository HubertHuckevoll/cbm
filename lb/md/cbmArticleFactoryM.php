<?php

class cbmArticleFactoryM
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
   * Summary of produceList
   * @param mixed $startIdx
   * @param mixed $num
   * @return array
   * ________________________________________________________________
   */
  public function produceList(): array
  {
    $result = $this->produceFromTo(0, count($this->indexData));
    return $result;
  }

  public function search(string $term): array
  {
    $data = [];
    $result = [];
    $i = 0;

    $term = mb_strtolower($term);

    foreach($this->indexData as $articleEntry)
    {
      if (!isset($articleEntry)) break;
      $data = [];
      $article = new cbmArticleM($articleEntry['store'], $articleEntry['articleBox'], $articleEntry['articleName']);
      $data = $article->get();

      foreach($data as $key => $val)
      {
        if ($key !== 'images')
        {
          $val = mb_strtolower($term);
          $val = strip_tags($val);
          if (($pos = mb_stripos($val, $term)) !== false)
          {
            $hit = $this->extractHit($val, $term, $pos);
            $hit = str_ireplace($term, '<strong>'.$term.'</strong>', $hit);
            array_push($result, [
              'article' => $article,
              'hit' => $hit
            ]);
          }
        }
      }
    }

    return $result;
  }

  protected function extractHit($text, $searchStr, $pos)
  {
    $start = ($pos - 75 > 0) ? $pos - 75 : 0;
    $hit = substr($text, $start, (strlen($searchStr) + 150));
    $hit = '...'.$hit.'...';
    return $hit;
  }

  /**
   * Summary of get
   * @param int $startIdx
   * @param int $num
   * @return array
   * ________________________________________________________________
   */
  public function produceFromTo(int $startIdx, int $num): array
  {
    $data = [];
    $result = [];
    $i = 0;

    for ($i = $startIdx; $i < ($startIdx+$num); $i++)
    {
      if (!isset($this->indexData[$i])) break;
      $data = [];
      $a = new cbmArticleM($this->indexData[$i]['store'], $this->indexData[$i]['articleBox'], $this->indexData[$i]['articleName']);
      $data = $a->get();

      array_push($result, $data);
    }

    return $result;
  }

}

?>