<?php

class cbmAppC
{
  protected string $store = '';
  protected string $mainControllerName = 'indexC';
  protected string $mainMethodName = 'show';

  /**
   * Konstruktor
   * ________________________________________________________________
   */
  public function __construct(string $store)
  {
    $this->store = $store;
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

    $controllerObj = new $modName($this->store, $request);

    if ((isset($controllerObj) && method_exists($controllerObj, $methodName)))
    {
      call_user_func(array($controllerObj, $methodName));
    }
    else
    {
      redirect();
    }
  }

}

?>