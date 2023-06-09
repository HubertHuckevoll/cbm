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