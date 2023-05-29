<?php

trait cbmToolsVF
{

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

  public function renderCbmHead()
  {
    $html  = '';
    $html .= '<meta name="viewport" content="width=device-width, initial-scale=1">'.
             '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@exampledev/new.css@1/new.min.css">';

    return $html;
  }


}

?>