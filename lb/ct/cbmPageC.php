<?php

class cbmPageC
{
  protected object $view;
  protected string $store = '';
  protected ?array $prefs = null;

  /**
   * Summary of __construct
   * @param mixed $view
   * @param mixed $store
   * @param mixed $prefs
   * ________________________________________________________________
   */
  public function __construct(object $view, string $store, ?array $prefs = null)
  {
    $this->view = $view;
    $this->store = $store;
    $this->prefs = $prefs;
  }
}

?>
