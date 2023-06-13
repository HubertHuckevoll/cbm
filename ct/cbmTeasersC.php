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

  public function __construct(string $store, array $request, object $view, ?array $prefs = null)
  {
    $this->tags = ($request['tags']) ?? '';
    $this->num = ($request['num']) ?? null;

    parent::__construct($view, $store, $prefs);
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

    $this->view->set('teasers', 'articles', $data);

    $this->view->draw();
  }

}

?>
