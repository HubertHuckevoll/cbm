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
    $articles = $this->getData('articles');

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
    $articles = $this->getData('articles');

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
}

?>