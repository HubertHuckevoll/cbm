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

  public function cbmHeader()
  {
    return $this->getData('title') ?? '';
  }

  public function cbmDate()
  {
    $timestamp = $this->getData('date');
    return $this->renderDate($timestamp);
  }

  public function cbmContent()
  {
    return $this->getData('content') ?? '';
  }

  public function cbmSection()
  {
    return $this->renderGallery($this->getData('images'));
  }

  public function cbmAside()
  {
    return '';
  }

  public function cbmFooter()
  {
    return '';
  }

}

?>