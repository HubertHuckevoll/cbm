<?php

class cbmAppC
{
  protected string $mainControllerName = '';
  protected string $mainMethodName = '';

  /**
   * Konstruktor
   * ________________________________________________________________
   */
  public function __construct(string $mainControllerName, string $mainMethodName, $linker = null, $requestM = null)
  {
    $this->mainControllerName = $mainControllerName;
    $this->mainMethodName = $mainMethodName;
  }

  /**
   * run with a path pattern of index.php/mod/hook?queryparams=xyz
   * ________________________________________________________________
   */
  public function runWithPathInfo(): void
  {
    $dummy = '';
    $pathInfo = '';
    $modName = '';
    $methodName = '';

    if (isset($_SERVER['PATH_INFO']))
    {
      $pathInfo = $_SERVER['PATH_INFO'];
      list($dummy, $modName, $methodName) = explode('/', $pathInfo); // $dummy => PATH_INFO has a leading "/" that creates a fake first entry
    }
    else
    {
      $modName = $this->mainControllerName;
      $methodName = $this->mainMethodName;
    }

    $this->exec($modName, $methodName);
  }

  /**
   * call the controller
   * ________________________________________________________________
   */
  protected function exec(string $modName, string $methodName): void
  {
    $controllerObj = null;

    try
    {
      $controllerObj = new $modName();

      if ((isset($controllerObj) && method_exists($controllerObj, $methodName)))
      {
        call_user_func(array($controllerObj, $methodName));
      }
      else
      {
        die('Fatal error: Couldn\'t run method "'.$methodName.'" on object "'.$controllerObj.'".');
      }
    }
    catch(Exception $e)
    {
      die('Fatal error: Couldn\'t instantiate object "'.$controllerObj.'".');
    }
  }
}

?>