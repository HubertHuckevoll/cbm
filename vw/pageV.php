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

  public function cbmHead()
  {
    return $this->renderCbmHead();
  }

  public function cbmContent()
  {
    return $this->getData('content') ?? '';
  }
}

?>