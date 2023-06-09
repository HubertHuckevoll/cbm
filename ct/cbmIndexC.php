<?php

class cbmIndexC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'entries';
  protected mixed $requestedPage = null;
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
    $this->requestedPage = ($request['page']) ?? 0;
    $this->tags = ($request['tags']) ?? '';

    $this->articlesPerPage = $prefs['articlesPerPage'] ?? 10;
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $page = 0;
    $entries = [];
    $fr = null;
    $maxPage = null;

    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $fr->read();
    $entries = $fr->get($this->tags);

    $maxPage = ceil(count($entries) / $this->articlesPerPage);
    $page = ($this->requestedPage < $maxPage) ? $this->requestedPage : 0;
    if ($page < 0) $page = 0;

    $af = new cbmArticleFactoryM($entries);

    $articles = $af->produceFromTo(($page * $this->articlesPerPage), $this->articlesPerPage);

    $index['maxPage'] = $maxPage;
    $index['page'] = $page;
    $index['tags'] = $this->tags;

    $this->view->drawPage($index, $articles);
  }

}

?>
