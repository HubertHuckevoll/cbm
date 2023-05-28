<?php

class cbmPageV
{
  protected array $data = [];
  protected string $templName = '';
  protected string $htmlTemplate = '';
  protected string $localViewFolder = '/vw/';
  protected string $builtInViewFolder = '/cbm/vw.builtIn/';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $templName)
  {
    $this->templName = $templName;
    $this->htmlTemplate = $this->getTemplate();
  }

  public function getTemplate(): string
  {
    $fname = dirname($_SERVER['SCRIPT_FILENAME']).$this->localViewFolder.$this->templName.'.htmlt';
    if (!file_exists($fname))
    {
      $fname = $_SERVER['DOCUMENT_ROOT'].$this->builtInViewFolder.$this->templName.'.htmlt';
    }

    $fc = file_get_contents($fname);

    if ($fc !== false)
    {
      return $fc;
    }
    else
    {
      throw new Exception('Can\'t read file "'.$fname.'"');
    }
  }

  /**
   * replace cbm tags
   * ________________________________________________________________
   */
  public function draw(): void
  {
    $tag = '';
    $tagName = '';
    $str = '';
    $matches = [];
    $re = '/<(cbm)-(.*)>/iuUs';

    preg_match_all($re, $this->htmlTemplate, $matches, PREG_SET_ORDER, 0);

    foreach($matches as $match)
    {
      $tag = $match[0]; // <cbm-nav>
      $prefix = $match[1]; // cbm
      $tagName = $match[2]; // nav
      $func = $prefix.ucfirst($tagName);
      $str = $this->exec($func);

      $this->htmlTemplate = str_replace($tag, $str, $this->htmlTemplate);
    }

    echo $this->htmlTemplate;
  }

  /**
   * add Data From Array
   * _________________________________________________________________
   */
  public function addDataFromArray(array $data): void
  {
    $this->data = array_merge($this->data, $data);
  }

  /**
   * replace Data From Array
   * _________________________________________________________________
   */
  public function replaceDataFromArray(array $data): void
  {
    $this->reset();
    $this->data = array_merge($this->data, $data);
  }

  /**
   * set data key
   * _________________________________________________________________
   */
  public function setData(string $key, mixed $val): void
  {
    $this->data[$key] = $val;
  }

  /**
   * get data key
   * _________________________________________________________________
   */
  public function getData(string $key): mixed
  {
    return $this->data[$key] ?? '';
  }

  /**
   * does key/val pair exist?
   * ________________________________________________________________
   */
  public function isData(string $key): bool
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
  public function exec(string $method): string
  {
    $str = '';
    if (method_exists($this, $method))
    {
      $str = $this->$method();
    }
    return $str;
  }
}

?>