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

  public function cbmHead()
  {
    return $this->renderCbmHead();
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
}

?>