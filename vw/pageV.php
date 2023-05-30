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

  public function cbmHeader()
  {
    return $this->get('article', 'title') ?? '';
  }

  public function cbmCss()
  {
    return $this->renderCbmCSS();
  }

  public function cbmContent()
  {
    return $this->get('article', 'content') ?? '';
  }
}

?>