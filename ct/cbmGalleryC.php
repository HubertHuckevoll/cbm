<?php

class cbmGalleryC extends cPageC
{
  protected string $store = '';
  protected string $articleBox = 'entries';
  protected string $articleName = '';
  protected ?int $imgIdx = null;
  protected string $tags = '';

  /**
   * Konstruktor
   * _________________________________________________________________
   */
  public function __construct(array $request, object $view, ?array $prefs = null)
  {
    $this->store = $prefs['store'] ?? null;
    parent::__construct($request, $view, $prefs);

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
    $article = $ar->get();

    $gallery['curIdx']  = isset($article['images'][$this->imgIdx]) ? $this->imgIdx : 0;
    $gallery['prevIdx'] = isset($article['images'][$this->imgIdx - 1]) ? ($this->imgIdx - 1) : (count($article['images']) - 1);
    $gallery['nextIdx'] = isset($article['images'][$this->imgIdx + 1]) ? ($this->imgIdx + 1) : 0;

    $this->view->drawPage($article, $gallery, $this->tags);
  }
}

?>