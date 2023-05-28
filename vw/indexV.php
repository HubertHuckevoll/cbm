<?php

class indexV extends cbmPageV
{
  public function cbmHeader()
  {
    $str  = '';
    $str .= ucfirst($this->getDataAll()[0]['articleBox']) ?? '';
    return $str;
  }

  public function cbmContent()
  {
    return $this->renderIndexWithTeaser($this->data);
  }
}

?>