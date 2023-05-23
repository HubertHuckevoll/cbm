<?php

class cbmIndexC extends cbmPageC
{

  protected string $articleBox = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  function __construct($view, string $articleBox)
  {
    parent::__construct($view);
    $this->articleBox = $articleBox;
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function index()
  {
    $fr = new cbmArticleFolderReaderM($this->articleBox);
    $data = $fr->get();

    $this->view->setData($this->articleBox, $data);
    $this->view->draw();
  }
}

?>