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
    return $this->renderArticleMetadata();
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
    $tags = ($this->get('index', 'tags') !== '') ? '&tags='.$this->get('index', 'tags') : '';

    if ($imgs !== null)
    {
      for($i=0; $i < count($imgs); $i++)
      {
        $img = $imgs[$i];
        $html .= '<a href="index.php/galleryC/show/'.$name.'?imgIdx='.$i.$tags.'">'.
                    '<img height="250" src="'.$img['src'].'" title="'.$img['title'].'" alt="'.$img['title'].'">'.
                 '</a>&nbsp;';
      }
    }

    return $html;
  }

  public function cbmFooter()
  {
    $page = $this->get('index', 'articleBoxPage');
    $tags = ($this->get('index', 'tags') !== '') ? '&tags='.$this->get('index', 'tags') : '';
    return '<a href="index.php/indexC/show?page='.$page.$tags.'">Zurück</a>';
  }
}

?>