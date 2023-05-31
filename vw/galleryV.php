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
    return $this->renderGallery();
  }
}

?>