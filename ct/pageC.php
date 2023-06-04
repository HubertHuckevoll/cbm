<?php

class pageC extends cbmPageC
{
  protected string $articleBox = 'pages';
  protected string $articleName = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $pv = new pageV('pageV');
    parent::__construct($pv, $store, $prefs);

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