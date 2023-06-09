<?php

class cbmTeasersC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $tags = '';
  protected ?int $num = null;

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $this->tags = ($request['tags']) ?? '';
    $this->num = ($request['num']) ?? null;

    $pv = new teasersV('teasersV');
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
    $entries = $fr->getRandom($this->tags, $this->num);

    $af = new cbmArticleFactoryM($entries);
    $data = $af->produceList();

    $this->view->set('index', 'articles', $data);

    $this->view->draw();
  }

}

?>
