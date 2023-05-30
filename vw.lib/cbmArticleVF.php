<?php

trait cbmArticleVF
{

  /**
   * Summary of renderMetadata
   * @return string
   */
  public function renderMetadata(): string
  {
    $str = '';
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $image0 = $this->get('article', 'images')[0]['src'] ?? null;
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
               '"@type": "NewsArticle",'.
               '"headline": "'.$title.'",'.
               '"dateModified": "'.date('c', $date).'",'.
               (($image0 != '') ? '"image": ["'.$image0.'"]' : '').
            '}'.
            '</script>';

    return $str;
  }

  /**
   * Summary of renderImageList
   * @return string
   */
  public function renderImageList(): string
  {
    $html  = '';
    $imgs = $this->get('article', 'images');
    $name = $this->get('article', 'articleName');

    if ($imgs !== null)
    {
      for($i=0; $i < count($imgs); $i++)
      {
        $img = $imgs[$i];
        $html .= '<a href="index.php/galleryC/show/'.$name.'?imgIdx='.$i.'">'.
                    '<img height="250" src="'.$img['src'].'" title="'.$img['title'].'" alt="'.$img['title'].'">'.
                 '</a>&nbsp;';
      }
    }

    return $html;
  }

  /**
   * Summary of renderGallery
   * @return string
   */
  public function renderGallery(): string
  {
    $curIdx = $this->get('gallery', 'curIdx');
    $nextIdx = $this->get('gallery', 'nextIdx');
    $prevIdx = $this->get('gallery', 'prevIdx');

    $cur     = $this->get('article', 'images')[$curIdx]['src'];
    $curDesc = $this->get('article', 'images')[$curIdx]['title'];
    $articleName = $this->get('article', 'articleName');

    $prev = 'index.php/galleryC/show/'.$articleName.'?imgIdx='.$prevIdx;
    $next = 'index.php/galleryC/show/'.$articleName.'?imgIdx='.$nextIdx;

    $erg = '<div>'.
            '<div>'.
              '<p>'.
                '<a href="'.$prev.'" title="Voriges Bild"><button>&laquo;</button></a>&nbsp;'.
                '<a href="'.$next.'" title="Nächstes Bild"><button>&raquo;</button></a>&nbsp;'.
                '<a href="index.php/articleC/show/'.$articleName.'" title="Zur&uuml;ck"><button>x</button></a>'.
              '</p>'.
            '</div>'.
            '<div>'.
              '<a href="'.$next.'">'.
                 '<img alt="'.$curDesc.'" title="'.$curDesc.'" src="'.$cur.'" style="cursor: pointer; border: none;" />'.
              '</a>'.
              '<p><em>'.$curDesc.'</em></p>'.
            '</div>'.
          '</div>';

    return $erg;
  }
}

?>