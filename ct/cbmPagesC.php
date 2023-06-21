<?php

class cbmPagesC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'pages';
  protected string $articleName = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(array $request, object $view, ?array $prefs = null)
  {
    $this->store = $prefs['store'] ?? null;
    parent::__construct($request, $view, $prefs);

    if (!isset($request['articleName'])) throw new Exception('articleName not set.');
    $this->articleName = $request['articleName'];
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
    $this->view->draw();
  }
}

?>