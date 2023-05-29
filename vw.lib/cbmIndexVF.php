<?php

trait cbmIndexVF
{

  /**
   * Summary of renderIndex
   * @return string
   */
  public function renderIndex(): string
  {
    $html  = '';
    $articles = $this->getData('cbm_articles');

    if ($articles !== null)
    {
      $html .= '<ul>';
      foreach($articles as $item)
      {
        $html .= '<li><a href="index.php/articleC/show/'.$item['articleName'].'">'.$item['articleName'].'</a></li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }

  /**
   * Summary of renderIndexWithTeaser
   * @return string
   */
  public function renderIndexWithTeaser(): string
  {
    $html  = '';
    $articles = $this->getData('cbm_articles');

    if ($articles !== null)
    {
      $html .= '<ul>';
      foreach($articles as $item)
      {
        $html .= '<li>'.
                   '<h4>'.$item['title'].'</h4>'.
                   '<div>'.$item['summary'].'</div>'.
                   '<a href="index.php/articleC/show/'.$item['articleName'].'">[read]</a>'.
                 '</li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }

  /**
   * Summary of renderArticleBoxPageNumbers
   * @return string
   * ________________________________________________________________
   */
  public function renderArticleBoxPageNumbers(): string
  {
    $html = '';
    $page = $this->getData('cbm_articleBoxPage');
    $maxPage = $this->getData('cbm_maxPage');

    for ($i = 0; $i < $maxPage; $i++)
    {
      if ($i == $page)
      {
        $html .= '<span>'.($i+1).'</span>&nbsp;';
      }
      else
      {
        $html .= '<a href="index.php/indexC/show?page='.$i.'"><button>'.($i+1).'</button></a>&nbsp;';
      }
    }

    return $html;
  }
}

?>