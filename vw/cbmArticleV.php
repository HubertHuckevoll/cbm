<?php

class cbmArticleV extends cbmPageV
{
  public function section($tagVal)
  {
    $html  = '';
    $html .= '<ul>';

    foreach($this->getData('gallery') as $img)
    {
      $html .= '<li><img src="'.$img.'"></li>';
    }
    $html .= '</ul>';

    return $html;
  }
}

?>