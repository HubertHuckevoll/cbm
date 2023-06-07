<?php

class cbmArticleC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $articleName = '';
  public ?int $articlesPerPage = null;
  protected string $tags = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $pv = new articleV('articleV');
    parent::__construct($pv, $store, $prefs);

    $this->articlesPerPage = $prefs['articlesPerPage'] ?? 10;

    if (!isset($request['articleName'])) throw new Exception('articleName not set.');
    $this->articleName = $request['articleName'];
    $this->tags = $request['tags'] ?? '';
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $ar = new cbmArticleM($this->store, $this->articleBox, $this->articleName);
    $data = $ar->get();
    $this->view->set('article', $data);
    $this->view->set('index', 'articleBoxPage', $this->getBoxPageForArticle());
    $this->view->set('index', 'tags', $this->tags);

    $this->view->draw();
  }

  /**
   * Summary of getBoxPageForArticle
   * @return int
   * ________________________________________________________________
   */
  protected function getBoxPageForArticle(): int
  {
    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $fr->read();
    $names = $fr->get($this->tags);
    $names = array_column($names, 'articleName');
    $idx = array_search($this->articleName, $names);
    $page = ceil($idx / $this->articlesPerPage);
    if (bcmod($idx, $this->articlesPerPage) != 0) $page--;

    return $page;
  }
}

?>