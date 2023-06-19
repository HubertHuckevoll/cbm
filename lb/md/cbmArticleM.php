<?php

class cbmArticleM
{
  use cbmArticleToolsM;

  protected string $store = '';
  protected string $articleBox = '';
  protected string $articleName = '';
  protected string $articleFile = '';

  /**
   * Summary of __construct
   * @param mixed $store
   * @param mixed $articleBox
   * @param mixed $articleName
   * ________________________________________________________________
   */
  public function __construct(string $store, string $articleBox, string $articleName)
  {
    $this->store = $store;
    $this->articleBox = $articleBox;
    $this->articleName = $articleName;
    $this->articleFile = $_SERVER['DOCUMENT_ROOT'].'/'.$this->store.'/'.$this->articleBox.'/'.$this->articleName.'.xml';
  }

  /**
   * Summary of get
   * @return array
   * ________________________________________________________________
   */
  public function get(): array
  {
    $result = [];
    $fileContent = $this->readFile();
    $xml = simplexml_load_string($fileContent, null, LIBXML_NOCDATA | LIBXML_NOBLANKS);

    foreach($xml->children() as $nodeName => $nodeVal)
    {
      if ($nodeName == 'content')
      {
        $result[$nodeName] = $this->reworkURLs((string) $nodeVal);
      }
      elseif ($nodeName == 'images')
      {
        $result['images'] = [];
        foreach($nodeVal->children() as $img)
        {
          array_push($result['images'], [
            'src'   => '/'.$this->store.'/'.$this->articleBox.'.assets/'.(string) $img,
            'title' => (string) $img['title']
          ]);
        }
      }
      else
      {
        $result[$nodeName] = (string) $nodeVal;
      }
    }

    $result['store'] = $this->store;
    $result['articleBox'] = $this->articleBox;
    $result['articleName'] = $this->articleName;
    $result['date'] = $this->extractDateFromArticleName();

    return $result;
  }

  /**
   * Summary of readFile
   * @throws \Exception
   * @return bool|string
   * ________________________________________________________________
   */
  public function readFile(): string
  {
    $fc = file_get_contents($this->articleFile);
    if ($fc !== false)
    {
      return $fc;
    }
    else
    {
      throw new Exception('Can\'t read file "'.$this->articleFile.'"');
    }
  }

  /**
   * Summary of extractDateFromArticleName
   * @return bool|int
   * ________________________________________________________________
   */
  protected function extractDateFromArticleName(): int
  {
    $dateStamp = $this->parseFilename($this->articleName.'.xml')['date'];
    return $dateStamp;
  }

  /**
   * Summary of reworkURLs
   * @param mixed $html
   * @return array|string|null
   * ________________________________________________________________
   */
  protected function reworkURLs(string $html): array|string|null
  {
    // rework image urls
    $pattern = '/src="([^\/]*)"/mU';
    $replacement = 'src="/'.$this->store.'/'.$this->articleBox.'.assets/'.'$1"';
    $html = preg_replace($pattern, $replacement, $html);

    // rework hrefs with download attribute
    $pattern = '/<a.*href="(.*)".*>/mU';
    $links = [];
    if (preg_match_all($pattern, $html, $links, PREG_SET_ORDER, 0) > 0)
    {
      foreach ($links as $link)
      {
        if (strpos(strtolower($link[0]), 'download') !== false)
        {
          $html = str_replace('href="'.$link[1].'"', 'href="'.'/'.$this->store.'/'.$this->articleBox.'.assets/'.$link[1].'"', $html);
        }
      }
    }

    return $html;
  }

}

?>