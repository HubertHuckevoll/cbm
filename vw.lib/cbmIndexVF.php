<?php

trait cbmIndexVF
{

  /**
   * Summary of renderIndex
   * @param null| $articles
   * @return string
   */
  public function renderIndex(null|array $articles): string
  {
    $html  = '';

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
   * @param null| $articles
   * @return string
   */
  public function renderIndexWithTeaser(null|array $articles): string
  {
    $html  = '';

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