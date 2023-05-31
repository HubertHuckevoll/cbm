<?php

class pageC extends cbmPageC
{
  protected string $articleBox = 'pages';
  protected string $articleName = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $store, array $request)
  {
    $pv = new articleV('pageV');
    parent::__construct($pv, $store);

    if (!isset($request['articleName'])) redirect();
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