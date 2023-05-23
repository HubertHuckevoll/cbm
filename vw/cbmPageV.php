<?php

class cbmPageV
{
  public array $data = []; // model data
  public string $htmlTemplate = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $templName)
  {
    try
    {
      $tfr = new cbmTemplateFileReaderM($templName);
      $this->htmlTemplate = $tfr->get();
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }

  /**
   * replace cbm tags
   * ________________________________________________________________
   */
  public function draw()
  {
    $tag = '';
    $tagName = '';
    $str = '';
    $matches = [];
    $re = '/<cbm-(.*)>/iuUs';

    preg_match_all($re, $this->htmlTemplate, $matches, PREG_SET_ORDER, 0);

    foreach($matches as $match)
    {
      $tag = $match[0]; // <cbm-nav>
      $tagName = $match[1]; // nav
      $str = ($this->isData($tagName)) ? $this->getData($tagName) : '';
      $str = $this->exec($tagName, $str);

      $this->htmlTemplate = str_replace($tag, $str, $this->htmlTemplate);
    }

    echo $this->htmlTemplate;
  }

  /**
   * add Data From Array
   * _________________________________________________________________
   */
  public function addDataFromArray(array $data)
  {
    $this->data = array_merge($this->data, $data);
  }

  /**
   * replace Data From Array
   * _________________________________________________________________
   */
  public function replaceDataFromArray(array $data)
  {
    $this->reset();
    $this->data = array_merge($this->data, $data);
  }

  /**
   * set data key
   * _________________________________________________________________
   */
  public function setData($key, $val)
  {
    $this->data[$key] = $val;
  }

  /**
   * get data key
   * _________________________________________________________________
   */
  public function getData($key)
  {
    return $this->data[$key] ?? '';
  }

  /**
   * does key/val pair exist?
   * ________________________________________________________________
   */
  public function isData($key)
  {
    return isset($this->data[$key]) ? true : false;
  }

  /**
   * reset data
   * _________________________________________________________________
   */
  public function reset()
  {
    $this->data = [];
  }

  /**
   * execute a draw function dynamically
   * _________________________________________________________________
   */
  public function exec(string $method, string $tagVal)
  {
    if (method_exists($this, $method))
    {
      $tagVal = $this->$method($tagVal);
    }
    return $tagVal;
  }
}

?>