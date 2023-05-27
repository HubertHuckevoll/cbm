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
  public function show(): void
  {
    $fr = new cbmArticleFolderReaderM($this->store, $this->articleBox);
    $data = $fr->get();

    $this->view->setData('meta', ['articleBox' => $this->articleBox]);
    $this->view->setData($this->articleBox, $data);
    $this->view->draw();
  }

  public function showIndexWithTeaser(): void
  {
    $ff = new cbmArticleFactoryM($this->store, $this->articleBox);
    $data = $ff->get(0, 10);

    $this->view->setData('meta', ['articleBox' => $this->articleBox]);
    $this->view->setData($this->articleBox, $data);
    $this->view->draw();
  }
}

?>
