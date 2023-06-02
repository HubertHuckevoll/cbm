<?php

class galleryV extends cbmPageV
{
  public function cbmBase()
  {
    return $this->renderBaseTag();
  }

  public function cbmTitle()
  {
    return $this->get('article', 'title') ?? '';
  }

  public function cbmHeader()
  {
    return $this->get('article', 'title') ?? '';
  }

  public function cbmContent()
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
                '<a href="'.$prev.'" title="Voriges Bild"><span>&laquo;</span></a>&nbsp;'.
                '<a href="'.$next.'" title="Nächstes Bild"><span>&raquo;</span></a>&nbsp;'.
                '<a href="index.php/articleC/show/'.$articleName.'" title="Zur&uuml;ck"><span>x</span></a>'.
              '</p>'.
            '</div>'.
            '<div>'.
              '<a href="'.$next.'">'.
                 '<img alt="'.$curDesc.'" title="'.$curDesc.'" src="'.$cur.'">'.
              '</a>'.
              '<p><em>'.$curDesc.'</em></p>'.
            '</div>'.
          '</div>';

    return $erg;
  }
}

?>