<?php

class cbmAppC
{
  protected string $store = '';
  protected string $mainControllerName = '';
  protected string $mainMethodName = '';

  /**
   * Konstruktor
   * ________________________________________________________________
   */
  public function __construct(string $store, string $mainControllerName, string $mainMethodName)
  {
    $this->store = $store;
    $this->mainControllerName = $mainControllerName;
    $this->mainMethodName = $mainMethodName;
  }

  /**
   * run with a path pattern of index.php/mod/hook?queryparams=xyz
   * ________________________________________________________________
   */
  public function runWithPathInfo(): void
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
      $controllerObj = new $modName($this->store, $request);

      if ((isset($controllerObj) && method_exists($controllerObj, $methodName)))
      {
        call_user_func(array($controllerObj, $methodName));
      }
      else
      {
        throw new Exception('Fatal error: Couldn\'t run method "'.$methodName.'" on object "'.$modName.'".');
      }
    }
    catch(Exception $e)
    {
      throw $e;
    }
  }
}

?>