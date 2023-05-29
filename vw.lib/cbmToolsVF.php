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
  public function renderCbmHead(): string
  {
    $html  = '';
    $html .= '<meta charset="UTF-8">'.
             '<meta name="viewport" content="width=device-width, initial-scale=1">'.
             '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@exampledev/new.css@1/new.min.css">';

    return $html;
  }

}

?>