<?php

class articleV extends cbmPageV
{
  public function cbmBase()
  {
    return $this->renderBaseTag();
  }

  public function cbmTitle()
  {
    return $this->get('article', 'title') ?? '';
  }

  public function cbmMetadata()
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
               '"@type": "Article",'.
               '"headline": "'.$title.'",'.
               '"author": "'.$author.'",'.
               '"dateModified": "'.date('c', $date).'",'.
               (($image0 != '') ? '"image": ["'.$image0.'"]' : '').
            '}'.
            '</script>';

    return $str;
  }

  public function cbmHeader()
  {
    return $this->get('article', 'title') ?? '';
  }

  public function cbmDate()
  {
    $timestamp = $this->get('article', 'date');
    return $this->renderDate($timestamp);
  }

  public function cbmArticle()
  {
    return $this->get('article', 'content') ?? '';
  }

  public function cbmImages()
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

  public function cbmFooter()
  {
    return '<a href="index.php/indexC/show?page='.$this->get('index', 'articleBoxPage').'">Zurück</a>';
  }
}

?>