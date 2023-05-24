<?php

class cbmIndexC extends cbmPageC
{

  protected string $articleBox = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  function __construct(object $view, string $store, string $articleBox)
  {
    parent::__construct($view, $store);
    $this->articleBox = $articleBox;
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function index(): void
  {
    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $data = $fr->get();

    $this->view->setData($this->articleBox, $data);
    $this->view->draw();
  }
}

?>
