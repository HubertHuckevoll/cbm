<?php

trait cbmToolsV
{

  /**
   * Summary of renderBaseTag
   * @return string
   * ________________________________________________________________
   */
  protected function renderBaseTag(): string
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
  protected function renderDate(int $timestamp): bool|string
  {
    $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

    $html = $formatter->format($timestamp);
    $html = ($html !== false) ? $html : '-';

    return $html;
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

    $str .= '<script type="application/ld+json">'.
            '{'.
               '"@context": "https://schema.org",'.
               '"@type": "Article",'.
               '"headline": "'.$title.'",'.
               '"author": "'.$author.'",'.
               '"dateModified": "'.date('c', $date).'",'.
               (($image0 != '') ? '"image": ["'.$image0.'"]' : '').
            '}'.
            '</script>';

    return $str;
  }

  protected function renderHrefIndex(?int $page): string
  {
    $tags = ($this->get('index', 'tags') !== '') ? '/['.$this->get('index', 'tags').']' : '';
    $str = 'index.php/indexC/show'.$tags.'?page='.$page;

    return $str;
  }

  protected function renderHrefArticle(string $articleName): string
  {
    $tags = ($this->get('index', 'tags') !== '') ? '/['.$this->get('index', 'tags').']/' : '/';
    $str  = 'index.php/articleC/show'.$tags.$articleName;

    return $str;
  }

  protected function renderHrefGallery(string $articleName, int $idx): string
  {
    $tags = ($this->get('index', 'tags') !== '') ? '/['.$this->get('index', 'tags').']/' : '/';
    $str  = 'index.php/galleryC/show'.$tags.$articleName.'?imgIdx='.$idx;

    return $str;
  }

  protected function renderHrefPages(string $articleName): string
  {
    $str = 'index.php/pagesC/show/'.$articleName;

    return $str;
  }

}

?>