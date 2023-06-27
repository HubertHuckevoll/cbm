<?php

class cbmV extends cAppV
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
  protected function renderArticleMetadata(array $article): string
  {
    $str = '';
    $protocol = ($_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $image0 = $article['images'][0]['src'] ?? null;
    $image0 = ($image0 !== null) ? $protocol.$_SERVER['HTTP_HOST'].$image0 : null;
    $imageTitle = $article['images'][0]['title'] ?? '';
    $summary = $article['summary'] ?? '';
    $author = $article['author'] ?? $_SERVER['SERVER_NAME'];
    $title = $article['title'] ?? '';
    $date = $article['date'] ?? '';

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
  protected function renderHrefIndex(?int $page, ?string $tags = null): string
  {
    $tags = ($tags !== '') ? '/_'.$tags.'_' : '';
    $str = 'index.php/indexC/show'.$tags.'?page='.$page;

    return $str;
  }

  /**
   * Summary of renderHrefArticle
   * @param mixed $articleName
   * @return string
   * ________________________________________________________________
   */
  protected function renderHrefArticle(string $articleName, ?string $tags = null): string
  {
    $tags = ($tags !== '') ? '/_'.$tags.'_/' : '/';
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
  protected function renderHrefGallery(string $articleName, int $idx, ?string $tags = null): string
  {
    $tags = ($tags !== '') ? '/_'.$tags.'_/' : '/';
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

  /**
   * Summary of renderImageList
   * @param array $article
   * @param string $tags
   * @return string
   * ________________________________________________________________
   */
  protected function renderImageList(array $article, string $tags): string
  {
    $html = '';
    $imgs = $article['images'] ?? null;
    $name = $article['articleName'];

    if ($imgs !== null)
    {
      for($i=0; $i < count($imgs); $i++)
      {
        $img = $imgs[$i];
        $html .= '<a href="'.$this->renderHrefGallery($name, $i, $tags).'">'.
                    '<img height="250" src="'.$img['src'].'" title="'.$img['title'].'" alt="'.$img['title'].'">'.
                 '</a>';
      }
    }

    return $html;
  }

  /**
   * Summary of renderGallery
   * @param array $article
   * @param array $gallery
   * @param string $tags
   * @return string
   * ________________________________________________________________
   */
  public function renderGallery(array $article, array $gallery, string $tags): string
  {
    $curIdx  = $gallery['curIdx'];
    $nextIdx = $gallery['nextIdx'];
    $prevIdx = $gallery['prevIdx'];

    $cur         = $article['images'][$curIdx]['src'];
    $curDesc     = $article['images'][$curIdx]['title'];
    $articleName = $article['articleName'];

    $prev = $this->renderHrefGallery($articleName, $prevIdx, $tags);
    $next = $this->renderHrefGallery($articleName, $nextIdx, $tags);
    $back = $this->renderHrefArticle($articleName, $tags);

    $erg = <<<GALL
      <p>
        <a href="$prev" title="Previous"><button>&laquo;</button></a>
        <a href="$next" title="Next"><button>&raquo;</button></a>
        <a href="$back" title="Back"><button>x</button></a>
      </p>
      <p>
        <a href="$next">
          <img alt="$curDesc" title="$curDesc" src="$cur">
        </a>
      </p>
      <p>
        $curDesc
      </p>
    GALL;

    return $erg;
  }

  /**
   * Summary of renderArticleList
   * @param array $articles
   * @param string $tags
   * @return string
   * ________________________________________________________________
   */
  protected function renderArticleList(array $articles, string $tags): string
  {
    $listHtml = '<ul>';
    foreach($articles as $item)
    {
      $listHtml .= '<li>'.
                    '<a href="'.$this->renderHrefArticle($item['articleName'], $tags).'">'.$item['title'].'</a>'.
                    '<p>'.$item['summary'].'</p>'.
                   '</li>';
    }
    $listHtml .= '</ul>';

    return $listHtml;
  }

  /**
   * Summary of renderArticleListPages
   * @param array $index
   * @param array $articles
   * @return string
   * ________________________________________________________________
   */
  protected function renderArticleListPages(array $index, array $articles): string
  {
    $page = $index['page'];
    $maxPage = $index['maxPage'];

    $pageNrHtml = '<hr>';
    for ($i = 0; $i < $maxPage; $i++)
    {
      if ($i == $page)
      {
        $pageNrHtml .= '<span>'.($i+1).'</span>&nbsp;';
      }
      else
      {
        $pageNrHtml .= '<a href="'.$this->renderHrefIndex($i, $index['tags']).'"><span>'.($i+1).'</span></a>&nbsp;';
      }
    }

    return $pageNrHtml;
  }

  /**
   * Summary of renderSearchResults
   * @param array $entries
   * @param string $tags
   * @return string
   * ________________________________________________________________
   */
  protected function renderSearchResults(array $entries, string $tags): string
  {
    $str = '';
    foreach($entries as $entry)
    {
      $str .= '<p><a href="'.$this->renderHrefArticle($entry['article']['articleName'], $tags).'">'.$entry['hit'].'</a></p>';
    }
    return $str;
  }

  /**
   * Summary of renderTeaserList
   * @param array $articles
   * @param string $tags
   * @return string
   * ________________________________________________________________
   */
  protected function renderTeaserList(array $articles, string $tags): string
  {
    $str = '';
    foreach($articles as $article)
    {
      $str .= '<p><a href="'.$this->renderHrefArticle($article['articleName'], $tags).'">'.$article['articleName'].'</a></p>';
    }

    return $str;
  }

}

?>