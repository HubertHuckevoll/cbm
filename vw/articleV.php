<?php

class articleV extends cbmPageV
{
  public function cbmBase()
  {
    return $this->renderBaseTag();
  }

  public function cbmTitle()
  {
    return $this->getData('title') ?? '';
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
    return $this->getData('title') ?? '';
  }

  public function cbmDate()
  {
    $timestamp = $this->getData('date');
    return $this->renderDate($timestamp);
  }

  public function cbmArticle()
  {
    return $this->getData('content') ?? '';
  }

  public function cbmImages()
  {
    return $this->renderImageList();
  }

  public function cbmFooter()
  {
    return '<a href="index.php/indexC/show?page='.$this->getData('cbm_articleBoxPage').'">Zurück</a>';
  }
}

?>