<?php

class indexC extends cbmPageC
{

  protected string $articleBox = 'entries';
  protected mixed $requestedPage = null;
  public int $articlesPerPage = 2; // make sure this is equal in articleC!

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $this->requestedPage = ($request['page']) ?? 0;

    $pv = new indexV('indexV');
    parent::__construct($pv, $store, $prefs);
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $page = 0;
    $names = [];
    $fr = null;
    $maxPage = null;

    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $names = $fr->get();
    $maxPage = ceil(count($names) / $this->articlesPerPage);
    $page = ($this->requestedPage < $maxPage) ? $this->requestedPage : 0;
    if ($page < 0) $page = 0;

    $af = new cbmArticleFactoryM($this->store, $this->articleBox);
    $data = $af->get(($page * $this->articlesPerPage), $this->articlesPerPage);

    $this->view->set('index', 'maxPage', $maxPage);
    $this->view->set('index', 'page', $page);
    $this->view->set('articles', $data);
    $this->view->draw();
  }

}

?>
