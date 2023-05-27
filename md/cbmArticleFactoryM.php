<?php

class cbmArticleFactoryM
{
  protected string $store = '';
  protected string $articleBox = '';

  protected array $indexData = [];

  public function __construct($store, $articleBox)
  {
    $this->store = $store;
    $this->articleBox = $articleBox;
  }

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
      $data['meta']['date'] = $indexData[$i]['date'];
      $data['meta']['articleName'] = $indexData[$i]['articleName'];
      $data['article'] = $a->get();
      array_push($result, $data);
    }

    return $result;
  }

}

?>