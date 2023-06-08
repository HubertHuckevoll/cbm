<?php

class cbmTeasersV extends cbmPageV
{

  /**
   * Summary of __construct
   * @param mixed $templName
   * ________________________________________________________________
   */
  public function __construct()
  {}


  /**
   * Summary of drawRandom
   * @return mixed
   * ________________________________________________________________
   */
  public function drawRandom(): void
  {
    $str = '';
    $entries = $this->get('index', 'articles');

    foreach($entries as $entry)
    {
      $str .= '<p>'.$entry['articleName'].'</p>';
    }

    echo $str;
  }

}

?>