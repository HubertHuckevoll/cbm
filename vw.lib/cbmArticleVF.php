<?php

trait cbmArticleVF
{

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
      $html .= '<ul>';
      for($i=0; $i < count($imgs); $i++)
      {
        $img = $imgs[$i];
        $html .= '<li>'.
                 '<p>'.$img['alt'].'</p>'.
                 '<a href="index.php/galleryC/show/'.$this->getData('articleName').'?imgIdx='.$i.'"><img width="250" src="'.$img['src'].'"></a>'.
                 '</li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }

  /**
   * Summary of renderGallery
   * @return string
   */
  public function renderGallery()
  {
    $cur  = $this->getData('images')[$this->getData('curImg')]['src'];
    $curDesc = $this->getData('images')[$this->getData('curImg')]['alt'];

    $prev = 'index.php/galleryC/show/'.$this->getData('articleName').'?imgIdx='.$this->getData('prevImg');
    $next = 'index.php/galleryC/show/'.$this->getData('articleName').'?imgIdx='.$this->getData('nextImg');

    $erg = '<div>'.
            '<div>'.
              '<div>'.
                '<a href="'.$prev.'" title="Voriges Bild"><button>&laquo;</button></a>&nbsp;'.
                '<a href="'.$next.'" title="Nächstes Bild"><button>&raquo;</button></a>&nbsp;'.
                '<a href="index.php/articleC/show/'.$this->getData('articleName').'" title="Zur&uuml;ck"><button>x</button></a>'.
              '</div>'.
              '<div>'.$curDesc.'</div>'.
            '</div>'.
            '<div>'.
              '<a href="'.$next.'">'.
                 '<img alt="'.$curDesc.'" src="'.$cur.'" style="cursor: pointer; border: none;" />'.
              '</a>'.
            '</div>'.
          '</div>';

    return $erg;
  }
}

?>