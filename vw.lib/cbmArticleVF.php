<?php

trait cbmArticleVF
{

  public function renderDate(int $timestamp): string
  {
    $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
    return $formatter->format($timestamp);
  }

  public function renderGallery(null|array $imgs): string
  {
    $html  = '';

    if ($imgs !== null)
    {
      $html .= '<ul>';
      foreach($imgs as $img)
      {
        $html .= '<li>'.
                 '<span>'.$img['alt'].'</span><br>'.
                 '<img width="250" src="'.$img['src'].'">'.
                 '</li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }
}

?>