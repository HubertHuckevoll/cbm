<?php

class cbmIndexV extends cbmPageV
{
  public function content()
  {
    $html  = '';
    $html .= '<ul>';

    foreach($this->data['articles'] as $item)
    {
      $html .= '<li><a href="index.php/articleC/index/articles/'.$item.'">'.$item.'</a></li>';
    }
    $html .= '</ul>';

    return $html;
  }
}

?>