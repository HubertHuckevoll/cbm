<?php

class indexC extends cbmPageC
{

  protected string $articleBox = 'entries';
  protected mixed $requestedPage = null;
  public int $articlesPerPage = 2;

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request)
  {
    $this->requestedPage = ($request['page']) ?? null;

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
    $page = $this->getPageToShow($names, $maxPage);

    $af = new cbmArticleFactoryM($this->store, $this->articleBox);
    $data = $af->get($page, $this->articlesPerPage);

    $this->view->setData('maxPage', $maxPage);
    $this->view->setData('page', $page);
    $this->view->setData('articles', $data);
    $this->view->draw();
  }

  /**
   * get the page to show
   * _________________________________________________________________
   */
  protected function getPageToShow(array $names, int $maxPage): int
  {
    // if we're coming from a "back to index" link,
    // $page has the name of the article we're coming from.
    // We have to translate the name to an actual page number.
    // Don't fuck easily with this solution - it works pretty well...
    $page = 0;
    $idx = 0;

    if ($this->requestedPage !== null)
    {
      if (!is_numeric($this->requestedPage))
      {
        $names = array_column($names, 'articleName'); //extract "articleName" column
        $idx = array_search($this->requestedPage, $names);
        $page = ceil($idx / $this->articlesPerPage);
        if (bcmod($idx, $this->articlesPerPage) != 0) $page--;
      }
      else
      {
        if ($this->requestedPage < 0) $page = 0;
        $page = ($this->requestedPage < $maxPage) ? $this->requestedPage : $maxPage;
      }
    }

    return $page;
  }

}

?>
