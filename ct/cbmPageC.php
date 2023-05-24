<?php

class cbmPageC
{
  protected object $view;
  protected string $store = '';

  public function __construct(object $view, string $store)
  {
    $this->view = $view;
    $this->store = $store;
  }
}

?>
