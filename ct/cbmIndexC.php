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
    try
    {
      parent::__construct($view);
      $this->articleBox = $articleBox;
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
      $fr = new cbmArticleFolderReaderM($this->articleBox);
      $data = $fr->get();

      $this->view->setData($this->articleBox, $data);
      $this->view->draw();
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }
}

?>
