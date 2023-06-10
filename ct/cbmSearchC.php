<?php

class cbmSearchC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $tags = '';
  protected ?string $term = null;

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $this->tags = ($request['tags']) ?? '';
    $this->term = ($request['term']) ?? null;

    $pv = new searchV('searchV');
    parent::__construct($pv, $store, $prefs);
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

    $this->view->set('search', 'results', $data);

    $this->view->draw();
  }

}

?>
