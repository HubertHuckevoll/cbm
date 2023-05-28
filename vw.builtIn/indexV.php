<?php

class indexV extends cbmPageV
{
  use cbmIndexVF;

  public function cbmHeader()
  {
    $str  = '';

    logger::vh($this->data);

    $str .= ucfirst($this->getDataAll()[0]['articleBox']) ?? '';
    return $str;
  }

  public function cbmContent()
  {
    return $this->renderIndexWithTeaser($this->data);
  }
}

?>