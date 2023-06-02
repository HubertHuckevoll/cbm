<?php

class cbmAppC
{
  protected string $store = '';
  protected string $mainControllerName = 'indexC';
  protected string $mainMethodName = 'show';
  protected ?array $prefs = null;

  /**
   * Konstruktor
   * ________________________________________________________________
   */
  public function __construct(string $store, ?array $prefs = null)
  {
    $this->store = $store;
    $this->prefs = $prefs;
  }

  /**
   * run with a path pattern of index.php/mod/hook?queryparams=xyz
   * ________________________________________________________________
   */
  public function run(): void
  {
    $modName = '';
    $methodName = '';
    $rm = new cbmRequestM();

    $request = $rm->get();

    if (isset($request['mod']) && isset($request['hook']))
    {
      $modName = $request['mod'];
      $methodName = $request['hook'];
    }
    else
    {
      $modName = $this->mainControllerName;
      $methodName = $this->mainMethodName;
    }

    $this->exec($request, $modName, $methodName);
  }

  /**
   * call the controller
   * ________________________________________________________________
   */
  protected function exec(array $request, string $modName, string $methodName): void
  {
    $controllerObj = null;

    try
    {
      $controllerObj = new $modName($this->store, $request, $this->prefs);

      if ((isset($controllerObj) && method_exists($controllerObj, $methodName)))
      {
        call_user_func(array($controllerObj, $methodName));
      }
      else
      {
        $this->redirect();
      }
    }
    catch (Throwable $e)
    {
      $this->redirect();
    }
  }

  /**
   * redirect if everything fails
   * __________________________________________________________________
   */
  function redirect()
  {
    $prot = ($_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

    $href = '';
    $href = dirname($_SERVER['PHP_SELF']);
    $href = substr($href, 0, strrpos($href, 'index.php'));
    $href = rtrim($href, '/\\');
    $href = $prot.$_SERVER['HTTP_HOST'].$href.'/index.php/indexC/show';

    header('Location: '.$href);
  }

}

?>