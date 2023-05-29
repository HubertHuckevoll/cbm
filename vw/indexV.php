<?php

class indexV extends cbmPageV
{

  public function cbmBase()
  {
    return $this->renderBaseTag();
  }

  public function cbmHeader()
  {
    $str  = '';
    //$str .= ucfirst($this->getDataAll()[0]['articleBox']) ?? '';
    $str = $_SERVER['SERVER_NAME'];
    return $str;
  }

  public function cbmCss()
  {
    return $this->renderCbmCSS();
  }

  public function cbmContent()
  {
    return $this->renderIndexWithTeaser($this->data);
  }
}

?>