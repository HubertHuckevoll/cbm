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

  public function cbmCss()
  {
    return $this->renderCbmCSS();
  }

  public function cbmMetadata()
  {
    return $this->renderMetadata();
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
    return $this->renderImageList();
  }

  public function cbmFooter()
  {
    return '<a href="index.php/indexC/show?page='.$this->get('index', 'articleBoxPage').'">Zurück</a>';
  }
}

?>