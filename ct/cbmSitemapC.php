<?php

class cbmSitemapC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'entries';
  protected string $pagesBox = 'pages';

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(array $request, object $view, ?array $prefs = null)
  {
    $this->store = $prefs['store'] ?? null;
    parent::__construct($request, $view, $prefs);
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function create(): void
  {
    $articles = [];
    $pages = [];
    $fr = null;

    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $fr->read();
    $articles = $fr->get();

    $fr = new cbmArticleFolderReaderM($this->store, $this->pagesBox);
    $fr->read();
    $pages = $fr->get();

    $this->view->drawPage($articles, $pages);
  }

}

?>
