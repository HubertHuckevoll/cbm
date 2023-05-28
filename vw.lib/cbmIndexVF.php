<?php

trait cbmIndexVF
{

  public function renderBaseTag()
  {
    $href = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $href = substr($href, 0, strrpos($href, 'index.php'));
    return '<base href="'.$href.'">';
  }

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