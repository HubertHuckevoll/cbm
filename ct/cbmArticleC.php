<?php

class cbmArticleC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'entries';
  protected string $articleName = '';
  public ?int $articlesPerPage = null;
  protected string $tags = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(array $request, ?array $prefs = null, ?object $view = null)
  {
    parent::__construct($request, $prefs, $view);

    $this->store = $prefs['store'] ?? null;
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
    $article = $ar->get();
    $index = ['articleBoxPage' => $this->getBoxPageForArticle(), 'tags' => $this->tags];

    $this->view->drawPage($index, $article);
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
