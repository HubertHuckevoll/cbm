<?php

class cbmIndexV extends cbmPageV
{
  public function content(mixed $tagVal): string
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