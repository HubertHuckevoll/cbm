<?php

class cbmTeasersC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'entries';
  protected string $tags = '';
  protected ?int $num = null;

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(array $request, ?array $prefs = null, ?object $view = null)
  {
    parent::__construct($request, $prefs, $view);

    $this->store = $prefs['store'] ?? null;
    $this->tags = ($request['tags']) ?? '';
    $this->num = ($request['num']) ?? null;
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
    $articles = $af->produceList();

    $this->view->drawPage($articles, $this->tags);
  }

}

?>
