<?php

class galleryV extends cbmPageV
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

  public function cbmHeader()
  {
    return $this->getData('title') ?? '';
  }

  public function cbmContent()
  {
    return $this->renderGallery();
  }
}

?>