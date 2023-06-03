<?php

class indexC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected mixed $requestedPage = null;
  public ?int $articlesPerPage = null;
  protected ?string $tags = null;

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $this->requestedPage = ($request['page']) ?? 0;
    $this->tags = ($request['tags']) ?? '';

    $this->articlesPerPage = $prefs['articlesPerPage'] ?? 10;

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
    $data = $af->get(($page * $this->articlesPerPage), $this->articlesPerPage);

    $this->view->set('index', 'maxPage', $maxPage);
    $this->view->set('index', 'page', $page);
    $this->view->set('index', 'tags', $this->tags);
    $this->view->set('articles', $data);

    $this->view->draw();
  }

}

?>
