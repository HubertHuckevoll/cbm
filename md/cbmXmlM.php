<?php

class cbmXmlM
{
  use cbmToolsM;

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

    $result['xml'] = $xml;
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
}

?>