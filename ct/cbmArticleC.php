<?php

class cbmArticleC extends cbmPageC
{

  protected string $fileContent = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  function __construct($view, $articleBox, $articleName)
  {
    parent::__construct($view);

    $ar = new cbmArticleFileReaderM($articleBox, $articleName);
    $this->fileContent = $ar->get();
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function index()
  {
    $fp = new cbmHtmlFragmentParserM($this->fileContent);
    $data = $fp->parse();
    $this->view->addDataFromArray($data);

    $this->view->draw();
  }
}

?>
