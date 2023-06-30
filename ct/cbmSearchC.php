<?php

class cbmSearchC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'entries';
  protected string $tags = '';
  protected ?string $term = null;

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(array $request, ?array $prefs = null, ?object $view = null)
  {
    parent::__construct($request, $prefs, $view);

    $this->store = $prefs['store'] ?? null;
    $this->tags = ($request['tags']) ?? '';
    $this->term = ($request['term']) ?? null;
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function search(): void
  {
    $entries = [];
    $fr = null;
    $af = null;

    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $fr->read();
    $entries = $fr->get($this->tags);

    $af = new cbmArticleSearchM($entries);
    $data = $af->search($this->term);

    $this->view->drawPage($data, $this->tags);
  }

}

?>
