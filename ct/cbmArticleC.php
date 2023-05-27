<?php

class cbmArticleC extends cbmPageC
{
  protected string $articleBox = '';
  protected string $articleName = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  function __construct(object $view, string $store, string $articleBox, string $articleName)
  {
    parent::__construct($view, $store);
    $this->articleBox = $articleBox;
    $this->articleName = $articleName;
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $ar = new cbmArticleM($this->store, $this->articleBox, $this->articleName);
    $data = $ar->get();

    $this->view->setData('article', $data);
    $this->view->draw();
  }
}

?>
