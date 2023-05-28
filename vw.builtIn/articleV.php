<?php

class articleV extends cbmPageV
{
  use cbmArticleVF;

  public function cbmTitle()
  {
    return $this->getData('title') ?? '';
  }

  public function cbmHeader()
  {
    return $this->getData('title') ?? '';
  }

  public function cbmDate()
  {
    $timestamp = $this->getData('date');
    $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

    return $formatter->format($timestamp);
  }

  public function cbmContent()
  {
    return $this->getData('content') ?? '';
  }

  public function cbmSection()
  {
    return $this->renderGallery($this->getData('images'));
  }

  public function cbmAside()
  {
    return '';
  }

  public function cbmFooter()
  {
    return '';
  }

}

?>