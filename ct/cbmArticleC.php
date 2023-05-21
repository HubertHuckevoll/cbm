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
    try
    {
      parent::__construct($view);

      $ar = new cbmArticleFileReaderM($articleBox, $articleName);
      $this->fileContent = $ar->get();
    }
    catch(Exception $e)
    {
      throw $e;
    }
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function index()
  {
    try
    {
      $fp = new cbmHtmlFragmentParserM($this->fileContent);
      $data = $fp->parse();
      $this->view->addDataFromArray($data);

      $this->view->draw();
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }
}

?>
