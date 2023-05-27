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
      if (!isset($indexData['articles'][$i])) break;
      $data = [];
      $a = new cbmArticleM($this->store, $this->articleBox, $indexData['articles'][$i]['articleName']);
      $data = $a->get();
      $data['date'] = $indexData['articles'][$i]['date'];
      $data['articleName'] = $indexData['articles'][$i]['articleName'];

      array_push($result, $data);
    }

    $result = [
      'meta' => ['articleBox' => $this->articleBox],
      'articles' => $result
    ];

    return $result;
  }

}

?>