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
      $this->view->setData('title', 'The mighty index!');
      $this->view->setData('header', 'Look and see what\'s in store for you:');

      $fr = new cbmArticleFolderReaderM('articles');
      $data = $fr->get();

      $this->view->setData('articles', $data);
      $this->view->draw();
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }
}

?>
