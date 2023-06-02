<?php

trait cbmToolsV
{

  /**
   * Summary of renderBaseTag
   * @return string
   * ________________________________________________________________
   */
  public function renderBaseTag(): string
  {
    $href = dirname($_SERVER['PHP_SELF']);

    $hasIndexPhp = strpos($href, 'index.php');
    if ($hasIndexPhp)
    {
      $href = substr($href, 0, $hasIndexPhp);
    }

    $href = rtrim($href, '/\\');
    $href = $href.'/';

    return '<base href="'.$href.'">';
  }

  /**
   * Summary of renderDate
   * @param mixed $timestamp
   * @return bool|string
   * ________________________________________________________________
   */
  public function renderDate(int $timestamp): bool|string
  {
    $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

    $html = $formatter->format($timestamp);
    $html = ($html !== false) ? $html : '-';

    return $html;
  }

}

?>