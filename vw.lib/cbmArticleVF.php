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
    $image0 = $this->getData('images')[0]['src'] ?? null;

    $str .= '<meta name="description" content="'.($this->getData('summary') ?? '').'">';
    $str .= '<meta name="author" content="'.($this->getData('author') ?? $_SERVER['SERVER_NAME']).'">';
    $str .= ($image0 !== null) ? '<meta property="og:image" content="'.$image0.'">' : '';
    $str .= '<meta property="og:title" content="'.htmlentities($this->getData('title') ?? '').'">';
    $str .= '<meta property="og:description" content="'.htmlentities($this->getData('summary') ?? '').'">';
    $str .= '<meta property="og:type" content="Website">';
    $str .= '<meta property="og:url" content="'.$url.'">';
    $str .= '<meta property="og:site_name" content="'.$_SERVER['SERVER_NAME'].'">';

    $str .= '<script type="application/ld+json">'.
            '{'.
               '"@context": "https://schema.org",'.
               '"@type": "NewsArticle",'.
               '"headline": "'.$this->getData('title').'",'.
               '"dateModified": "'.$this->getData('date').'",'.
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
    $imgs = $this->getData('images');

    if ($imgs !== null)
    {
      for($i=0; $i < count($imgs); $i++)
      {
        $img = $imgs[$i];
        $html .= '<a href="index.php/galleryC/show/'.$this->getData('articleName').'?imgIdx='.$i.'">'.
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
    $cur  = $this->getData('images')[$this->getData('cbm_curImg')]['src'];
    $curDesc = $this->getData('images')[$this->getData('cbm_curImg')]['title'];

    $prev = 'index.php/galleryC/show/'.$this->getData('articleName').'?imgIdx='.$this->getData('cbm_prevImg');
    $next = 'index.php/galleryC/show/'.$this->getData('articleName').'?imgIdx='.$this->getData('cbm_nextImg');

    $erg = '<div>'.
            '<div>'.
              '<p>'.
                '<a href="'.$prev.'" title="Voriges Bild"><button>&laquo;</button></a>&nbsp;'.
                '<a href="'.$next.'" title="Nächstes Bild"><button>&raquo;</button></a>&nbsp;'.
                '<a href="index.php/articleC/show/'.$this->getData('articleName').'" title="Zur&uuml;ck"><button>x</button></a>'.
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