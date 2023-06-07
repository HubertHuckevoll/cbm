<?php

class cbmGalleryC extends cbmPageC
{
  protected string $articleBox = 'entries';
  protected string $articleName = '';
  protected ?int $imgIdx = null;
  protected string $tags = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(string $store, array $request, ?array $prefs = null)
  {
    $pv = new galleryV('galleryV');
    parent::__construct($pv, $store, $prefs);

    if (!isset($request['articleName'])) throw new Exception('articleName not set.');
    $this->articleName = $request['articleName'];
    $this->imgIdx = $request['imgIdx'] ?? 0;
    $this->tags = $request['tags'] ?? '';
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

    $this->view->set('index', 'tags', $this->tags);
    $this->view->set('article', $data);
    $this->view->set('gallery', 'curIdx', $curIdx);
    $this->view->set('gallery', 'nextIdx', $nextIdx);
    $this->view->set('gallery', 'prevIdx', $prevIdx);

    $this->view->draw();
  }
}

?>