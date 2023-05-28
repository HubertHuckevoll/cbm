<?php

trait cbmArticleVF
{
  public function renderGallery(null|array $imgs): string
  {
    $html  = '';

    if ($imgs !== null)
    {
      $html .= '<ul>';
      foreach($imgs as $img)
      {
        $html .= '<li><img src="'.$img['src'].'"><span>'.$img['alt'].'</span></li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }
}

?>