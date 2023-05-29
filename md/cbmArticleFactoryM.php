<?php

class cbmArticleFactoryM
{
  protected string $store = '';
  protected string $articleBox = '';

  protected array $indexData = [];

  /**
   * Summary of __construct
   * @param mixed $store
   * @param mixed $articleBox
   */
  public function __construct($store, $articleBox)
  {
    $this->store = $store;
    $this->articleBox = $articleBox;
  }

  /**
   * Summary of get
   * @param mixed $startIdx
   * @param mixed $num
   * @return array
   */
  public function get(int $startIdx, int $num): array
  {
    $box = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $indexData = $box->get();
    $data = [];
    $result = [];
    $i = 0;

    for ($i = $startIdx; $i < ($startIdx+$num); $i++)
    {
      if (!isset($indexData[$i])) break;
      $data = [];
      $a = new cbmArticleM($this->store, $this->articleBox, $indexData[$i]['articleName']);
      $data = $a->get();

      array_push($result, $data);
    }

    return $result;
  }

}

?>