<?php

trait cbmToolsVF
{

  /**
   * Summary of renderBaseTag
   * @return string
   */
  public function renderBaseTag(): string
  {
    $href = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $href = substr($href, 0, strrpos($href, 'index.php'));

    return '<base href="'.$href.'">';
  }

  /**
   * Summary of renderDate
   * @param mixed $timestamp
   * @return bool|string
   */
  public function renderDate(int $timestamp): string
  {
    $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

    return $formatter->format($timestamp);
  }

  /**
   * Summary of renderCbmHead
   * @return string
   */
  public function renderCbmCSS(): string
  {
    $html  = '';
    $html .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@exampledev/new.css@1/new.min.css">';
             //'<link rel="stylesheet" href="https://unpkg.com/sakura.css/css/sakura.css" type="text/css">';
             //'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">';
             //'<link rel="stylesheet" href="https://unpkg.com/marx-css/css/marx.min.css">';
             //'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.classless.min.css">';

    return $html;
  }

}

?>