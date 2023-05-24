<?php

class cbmArticleV extends cbmPageV
{
  public function section(mixed $tagVal): string
  {
    $html  = '';
    $html .= '<ul>';
    $imgs = ($this->isData('gallery')) ? $this->getData('gallery') : null;

    if ($imgs !== null)
    {
      foreach($this->getData('gallery') as $img)
      {
        $html .= '<li><img src="'.$img.'"></li>';
      }
    }
    $html .= '</ul>';

    return $html;
  }
}

?>