<?php

trait cbmToolsV
{

  /**
   * Summary of renderBaseHref
   * @return string
   * ________________________________________________________________
   */
  protected function renderBaseHref(): string
  {
    $href = dirname($_SERVER['PHP_SELF']);

    $hasIndexPhp = strpos($href, 'index.php');
    if ($hasIndexPhp)
    {
      $href = substr($href, 0, $hasIndexPhp);
    }

    $href = rtrim($href, '/\\');
    $href = $href.'/';

    return $href;
  }

  /**
   * Summary of renderBaseTag
   * @return string
   * ________________________________________________________________
   */
  protected function renderBaseTag(): string
  {
    return '<base href="'.$this->renderBaseHref().'">';
  }

  /**
   * Summary of renderDate
   * @param mixed $timestamp
   * @return bool|string
   * ________________________________________________________________
   */
  protected function renderDate(int $timestamp): bool|string
  {
    $locale = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']) : null;
    $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

    $html = $formatter->format($timestamp);
    $html = ($html !== false) ? $html : '-';

    return $html;
  }

  /**
   * Summary of renderTimestampToIso8601
   * @param int $timestamp
   * @return string
   * ________________________________________________________________
   */
  protected function renderTimestampToIso8601(int $timestamp): string
  {
    return date('c', $timestamp);
  }

  /**
   * render Article Metadata
   * @return string
   * ________________________________________________________________
   */
  protected function renderArticleMetadata(): string
  {
    $str = '';
    $protocol = ($_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $image0 = $this->get('article', 'images')[0]['src'] ?? null;
    $image0 = ($image0 !== null) ? $protocol.$_SERVER['HTTP_HOST'].$image0 : null;
    $imageTitle = $this->get('article', 'images')[0]['title'] ?? '';
    $summary = $this->get('article', 'summary') ?? '';
    $author = $this->get('article', 'author') ?? $_SERVER['SERVER_NAME'];
    $title = $this->get('article', 'title') ?? '';
    $date = $this->get('article', 'date') ?? '';

    $str .= '<meta name="description" content="'.$summary.'">';
    $str .= '<meta name="author" content="'.$author.'">';
    $str .= ($image0 !== null) ? '<meta property="og:image" content="'.$image0.'">' : '';
    $str .= '<meta property="og:title" content="'.htmlentities($title).'">';
    $str .= '<meta property="og:description" content="'.htmlentities($summary).'">';
    $str .= '<meta property="og:type" content="Website">';
    $str .= '<meta property="og:url" content="'.$url.'">';
    $str .= '<meta property="og:site_name" content="'.$_SERVER['SERVER_NAME'].'">';

    $str .= '<meta name="twitter:card" content="'.$imageTitle.'">';
    $str .= '<meta name="twitter:url" content="'.$url.'"/>';
    $str .= '<meta name="twitter:title" content="'.$title.'">';
    $str .= '<meta name="twitter:description" content="'.$summary.'">';
    $str .= '<meta name="twitter:image" content="'.$image0.'">';

    $str .= '<script type="application/ld+json">'.
            '{'.
               '"@context": "https://schema.org",'.
               '"@type": "Article",'.
               '"headline": "'.$title.'",'.
               '"author": "'.$author.'",'.
               '"dateModified": "'.$this->renderTimestampToIso8601($date).'",'.
               (($image0 != '') ? '"image": ["'.$image0.'"]' : '').
            '}'.
            '</script>';

    return $str;
  }

  /**
   * Summary of renderHrefIndex
   * @param mixed $page
   * @return string
   * ________________________________________________________________
   */
  protected function renderHrefIndex(?int $page): string
  {
    $tags = ($this->get('index', 'tags') !== '') ? '/['.$this->get('index', 'tags').']' : '';
    $str = 'index.php/indexC/show'.$tags.'?page='.$page;

    return $str;
  }

  /**
   * Summary of renderHrefArticle
   * @param mixed $articleName
   * @return string
   * ________________________________________________________________
   */
  protected function renderHrefArticle(string $articleName): string
  {
    $tags = ($this->get('index', 'tags') !== '') ? '/['.$this->get('index', 'tags').']/' : '/';
    $str  = 'index.php/articleC/show'.$tags.$articleName;

    return $str;
  }

  /**
   * Summary of renderHrefGallery
   * @param mixed $articleName
   * @param mixed $idx
   * @return string
   * ________________________________________________________________
   */
  protected function renderHrefGallery(string $articleName, int $idx): string
  {
    $tags = ($this->get('index', 'tags') !== '') ? '/['.$this->get('index', 'tags').']/' : '/';
    $str  = 'index.php/galleryC/show'.$tags.$articleName.'?imgIdx='.$idx;

    return $str;
  }

  /**
   * Summary of renderHrefPages
   * @param mixed $articleName
   * @return string
   * ________________________________________________________________
   */
  protected function renderHrefPages(string $articleName): string
  {
    $str = 'index.php/pagesC/show/'.$articleName;

    return $str;
  }

}

?>