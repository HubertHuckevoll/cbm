<?php

class cbmSitemapC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $pagesBox = 'pages';

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request, object $view, ?array $prefs = null)
  {
    parent::__construct($view, $store, $prefs);
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function create(): void
  {
    $entries = [];
    $fr = null;

    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $fr->read();
    $entries = $fr->get();
    $this->view->set('sitemap', 'articles', $entries);

    $fr = new cbmArticleFolderReaderM($this->store, $this->pagesBox);
    $fr->read();
    $entries = $fr->get();
    $this->view->set('sitemap', 'pages', $entries);

    $this->view->draw();
  }

}

?>
