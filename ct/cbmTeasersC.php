<?php

class cbmTeasersC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $tags = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $this->tags = ($request['tags']) ?? '';

    $pv = new teasersV();
    parent::__construct($pv, $store, $prefs);
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function random(): void
  {
    $entries = [];
    $fr = null;
    $af = null;

    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $fr->read();
    $entries = $fr->getRandom(10);

    $af = new cbmArticleFactoryM($entries);
    $data = $af->produceList();

    $this->view->set('index', 'articles', $data);

    $this->view->drawRandom();
  }

}

?>
