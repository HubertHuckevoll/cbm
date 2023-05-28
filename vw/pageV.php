<?php

class articleV extends cbmPageV
{
  public function cbmTitle()
  {
    return $this->getData('title') ?? '';
  }

  public function cbmHeader()
  {
    return $this->getData('title') ?? '';
  }

  public function cbmContent()
  {
    return $this->getData('content') ?? '';
  }
}

?>