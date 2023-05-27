<?php

trait cbmIndexVF
{
  public function renderIndex(null|array $articles): string
  {
    $html  = '';

    if ($articles !== null)
    {
      $html .= '<ul>';
      foreach($articles as $item)
      {
        $html .= '<li><a href="index.php/articleC/show/pages/'.$item['articleName'].'">'.$item['articleName'].'</a></li>';
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
        $html .= '<li><a href="index.php/articleC/show/pages/'.$item['meta']['articleName'].'">'.$item['meta']['articleName'].'</a>'.$item['article']['summary'].'</li>';
      }
      $html .= '</ul>';
    }

    return $html;
  }
}

?>