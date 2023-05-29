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

  public function __construct(string $store, array $request)
  {
    $this->requestedPage = ($request['page']) ?? 0;

    $pv = new indexV('indexV');
    parent::__construct($pv, $store);
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
    $page = ($this->requestedPage < $maxPage) ? $this->requestedPage : $maxPage;
    if ($page < 0) $page = 0;

    $af = new cbmArticleFactoryM($this->store, $this->articleBox);
    $data = $af->get($page, $this->articlesPerPage);

    $this->view->setData('cbm_maxPage', $maxPage);
    $this->view->setData('cbm_articleBoxPage', $page);
    $this->view->setData('cbm_articles', $data);
    $this->view->draw();
  }

}

?>
