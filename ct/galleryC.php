<?php

class galleryC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $articleName = '';
  protected ?int $imgIdx = null;

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $store, array $request)
  {
    $pv = new galleryV('galleryV');
    parent::__construct($pv, $store);

    $this->articleName = $request['articleName'];
    $this->imgIdx = $request['imgIdx'];
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $ar = new cbmArticleM($this->store, $this->articleBox, $this->articleName);
    $data = $ar->get();

    $curImg = $this->imgIdx;
    $prevImg = isset($data['images'][$this->imgIdx - 1]) ? ($this->imgIdx - 1) : (count($data['images']) - 1);
    $nextImg = isset($data['images'][$this->imgIdx + 1]) ? ($this->imgIdx + 1) : 0;

    $this->view->addDataFromArray($data);
    $this->view->setData('cbm_curImg', $curImg);
    $this->view->setData('cbm_nextImg', $nextImg);
    $this->view->setData('cbm_prevImg', $prevImg);

    $this->view->draw();
  }
}

?>