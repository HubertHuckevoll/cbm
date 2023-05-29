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
    $str = $_SERVER['SERVER_NAME'];
    return $str;
  }

  public function cbmCss()
  {
    return $this->renderCbmCSS();
  }

  public function cbmContent()
  {
    $html  = '';
    $html .= $this->renderIndexWithTeaser();
    $html .= '<hr>';
    $html .= $this->renderArticleBoxPageNumbers();

    return $html;
  }
}

?>