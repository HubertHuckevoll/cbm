<?php

class cbmArticleM
{
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
    $this->articleFile = $_SERVER['DOCUMENT_ROOT'].'/'.$this->store.'/'.$this->articleBox.'/'.$this->articleName.'.htmlf';
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
    $re = '/<cbm-(.*)>(.*)<\/cbm-\1>/iuUs';

    preg_match_all($re, $fileContent, $result, PREG_SET_ORDER, 0);
    $result = array_column($result, 2, 1);

    foreach($result as $tag => &$val)
    {
      $val = $this->reworkURLs($val);
      $val = $this->exec($tag, $val);
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
    $dateStr = substr($this->articleName, 0, 10).'T00:00:00'; // 2023-09-01 = 10 characters
    $dateStamp = strtotime($dateStr);

    return $dateStamp;
  }


  /**
   * execute a parse function dynamically
   * _________________________________________________________________
   */
  public function exec(string $method, string $tagVal): mixed
  {
    if (method_exists($this, $method))
    {
      $tagVal = $this->$method($tagVal);
    }

    return $tagVal;
  }

  /**
   * Summary of reworkURLs
   * @param mixed $html
   * @return array|string|null
   * ________________________________________________________________
   */
  protected function reworkURLs(string $html): string
  {
    $pattern = '/src="([^\/]*)"/mU';
    $replacement = 'src="/'.$this->store.'/'.$this->articleBox.'.assets/'.'$1"';
    $html = preg_replace($pattern, $replacement, $html);

    return $html;
  }

  /**
   * Summary of images
   * @param mixed $tagVal
   * @return array
   * ________________________________________________________________
   */
  protected function images(string $tagVal): array
  {
    $result = [];
    $images = [];
    $rawImgData = [];
    $finalImgData = [];
    $re = '';

    $re = '/<img.*>/mU';
    if (preg_match_all($re, $tagVal, $images, PREG_SET_ORDER, 0) > 0)
    {
      $images = array_column($images, 0);

      if (count($images) > 0)
      {
        foreach ($images as $img)
        {
          $re = '/<img.*src="(.*)".*>/mU';
          if (preg_match_all($re, $img, $rawImgData, PREG_SET_ORDER, 0) > 0)
          {
            if ($rawImgData[0][1] != '')
            {
              $finalImgData['src'] = $rawImgData[0][1];

              $re = '/<img.*title="(.*)".*>/mU';
              if (preg_match_all($re, $img, $rawImgData, PREG_SET_ORDER, 0) > 0)
              {
                $finalImgData['title'] = $rawImgData[0][1];
              }
              else
              {
                $finalImgData['title'] = '';
              }

              array_push($result, $finalImgData);
            }
          }
        }
      }
    }

    return $result;
  }

}

?>