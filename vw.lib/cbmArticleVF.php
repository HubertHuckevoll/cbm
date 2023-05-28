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
        $html .= '<li><img src="'.$img['src'].'"><span>'.$img['alt'].'</span></li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }
}

?>