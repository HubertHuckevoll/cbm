<?php

trait cbmIndexVF
{

  /**
   * Summary of renderIndex
   * @return string
   * ________________________________________________________________
   */
  public function renderIndex(): string
  {
    $html  = '';
    $articles = $this->get('articles');

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
   * ________________________________________________________________
   */
  public function renderIndexWithTeaser(): string
  {
    $html  = '';
    $articles = $this->get('articles');

    if ($articles !== null)
    {
      $html .= '<ul>';
      foreach($articles as $item)
      {
        $html .= '<li>'.
                   '<a href="index.php/articleC/show/'.$item['articleName'].'">'.$item['title'].'</a>'.
                   '<p>'.$item['summary'].'</p>'.
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
    $page = $this->get('index', 'page');
    $maxPage = $this->get('index', 'maxPage');

    for ($i = 0; $i < $maxPage; $i++)
    {
      if ($i == $page)
      {
        $html .= '<span>'.($i+1).'</span>&nbsp;';
      }
      else
      {
        $html .= '<a href="index.php/indexC/show?page='.$i.'"><span>'.($i+1).'</span></a>&nbsp;';
      }
    }

    return $html;
  }
}

?>