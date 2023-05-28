<?php

class articleC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $articleName = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $store, array $request)
  {
    $pv = new articleV('articleV');
    parent::__construct($pv, $store);

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

    $this->view->setData('meta', ['articleBox' => $this->articleBox]);
    $this->view->setData('article', $data);
    $this->view->draw();
  }
}

?>
