<?php

class indexC extends cbmPageC
{

  protected string $articleBox = 'entries';

  /**
   * Konstruktor
   * _________________________________________________________________
   */

  public function __construct(string $store, array $request)
  {
    $pv = new indexV('indexV');
    parent::__construct($pv, $store);
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $ff = new cbmArticleFactoryM($this->store, $this->articleBox);
    $data = $ff->get(0, 10);

    $this->view->addDataFromArray($data);
    $this->view->draw();
  }
}

?>
