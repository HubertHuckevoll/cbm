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

    if (!isset($request['articleName'])) redirect();
    $this->articleName = $request['articleName'];
    $this->imgIdx = $request['imgIdx'] ?? 0;
  }

  /**
   * Show Article
   * _________________________________________________________________
   */
  public function show(): void
  {
    $ar = new cbmArticleM($this->store, $this->articleBox, $this->articleName);
    $data = $ar->get();

    $curIdx  = isset($data['images'][$this->imgIdx]) ? $this->imgIdx : 0;
    $prevIdx = isset($data['images'][$this->imgIdx - 1]) ? ($this->imgIdx - 1) : (count($data['images']) - 1);
    $nextIdx = isset($data['images'][$this->imgIdx + 1]) ? ($this->imgIdx + 1) : 0;

    logger::vh($curIdx, $prevIdx, $nextIdx);

    $this->view->set('article', $data);
    $this->view->set('gallery', 'curIdx', $curIdx);
    $this->view->set('gallery', 'nextIdx', $nextIdx);
    $this->view->set('gallery', 'prevIdx', $prevIdx);

    $this->view->draw();
  }
}

?>