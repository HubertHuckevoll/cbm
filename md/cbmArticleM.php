<?php

class cbmArticleM
{
  protected string $store = '';
  protected string $articleBox = '';
  protected string $articleName = '';
  protected string $articleFile = '';

  public function __construct(string $store, string $articleBox, string $articleName)
  {
    $this->store = $store;
    $this->articleBox = $articleBox;
    $this->articleName = $articleName;
    $this->articleFile = $_SERVER['DOCUMENT_ROOT'].'/'.$this->store.'/'.$this->articleBox.'/'.$this->articleName.'.htmlf';
  }

  public function get(): array
  {
    $result = [];
    $fileContent = $this->readFile();
    $re = '/<cbm-(.*)>(.*)<\/cbm-\1>/iuUs';

    preg_match_all($re, $fileContent, $result, PREG_SET_ORDER, 0);

    $result = array_column($result, 2, 1);

    foreach($result as $tag => &$val)
    {
      $val = $this->exec($tag, $val);
    }

    return $result;
  }

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
              $finalImgData['src'] = '/'.$this->store.'/'.$this->articleBox.'.assets/'.$rawImgData[0][1];

              $re = '/<img.*alt="(.*)".*>/mU';
              if (preg_match_all($re, $img, $rawImgData, PREG_SET_ORDER, 0) > 0)
              {
                $finalImgData['alt'] = $rawImgData[0][1];
              }
              else
              {
                $finalImgData['alt'] = '';
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