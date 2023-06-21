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

  public function __construct(array $request, object $view, ?array $prefs = null)
  {
    $this->store = $prefs['store'] ?? null;
    parent::__construct($request, $view, $prefs);

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

    $data = $af->produceFromTo(($page * $this->articlesPerPage), $this->articlesPerPage);

    $this->view->set('index', 'maxPage', $maxPage);
    $this->view->set('index', 'page', $page);
    $this->view->set('index', 'tags', $this->tags);
    $this->view->set('articles', $data);

    $this->view->draw();
  }

}

?>
