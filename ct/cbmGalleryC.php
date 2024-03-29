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
  public function __construct(array $request, ?array $prefs = null, ?object $view = null)
  {
    parent::__construct($request, $prefs, $view);

    $this->store = $prefs['store'] ?? null;
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
    $ar = new cbmXmlM($this->store, $this->articleBox, $this->articleName);
    $article = $ar->get();

    $gallery['curIdx']  = isset($article['xml']->images->children()[$this->imgIdx]) ? $this->imgIdx : 0;
    $gallery['prevIdx'] = isset($article['xml']->images->children()[$this->imgIdx - 1]) ? ($this->imgIdx - 1) : ($article['xml']->images->count() - 1);
    $gallery['nextIdx'] = isset($article['xml']->images->children()[$this->imgIdx + 1]) ? ($this->imgIdx + 1) : 0;
    $gallery['cur']         = $article['xml']->images->children()[$gallery['curIdx']];
    $gallery['curDesc']     = $article['xml']->images->children()[$gallery['curIdx']]['title'];
    $gallery['store']       = $this->store;
    $gallery['articleBox']  = $this->articleBox;
    $gallery['articleName'] = $this->articleName;

    $this->view->drawPage($article, $gallery, $this->tags);
  }
}

?>