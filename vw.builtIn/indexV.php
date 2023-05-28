<?php

class indexV extends cbmPageV
{
  use cbmIndexVF;

  public function cbmHeader()
  {
    $str  = '';
    $str .= ucfirst($this->getData('meta')['articleBox']) ?? '';
    return $str;
  }

  public function cbmContent()
  {
    $articles = $this->getData('articles') ?? null;
    return $this->renderIndexWithTeaser($articles);
  }
}

?>