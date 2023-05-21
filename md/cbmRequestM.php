<?php

/**
 * give us request data
 * __________________________________________________________________
 */
class cbmRequestM
{
  public $routes = array();

  /**
   * add a route parser
   * ________________________________________________________________
   */
  public function add($path, $onPathMatch)
  {
    $this->routes[] = array('path' => $path, 'onPathMatch' => $onPathMatch);
  }

  /**
   * create a href for links / forms
   * returns a route if a matching route has been defined
   * and added via our add function
   * ________________________________________________________________
   */
  public function getReqVar($varName)
  {
    $pathInfoArr = $this->parsePathInfo($varName);

    $req = $_GET + $_POST + $pathInfoArr;

    $var = trim($varName);
    $var = preg_replace("/^(content-type:|bcc:|cc:|to:|from:)/im", "", $var);

    if (isset($req[$varName]))
    {
      $var = $req[$varName];
      return $var;
    }

    return false;
  }

  /**
   * do the path_info to "get-param" translation
   * ________________________________________________________________
   */
  protected function parsePathInfo($varName)
  {
    $pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $matches = array();
    $result = array();

    foreach ($this->routes as $route)
    {
      if ((preg_match($route['path'], $pathInfo, $matches)) === 1)
      {
        $keyVal = $route['onPathMatch']($matches);
        $result[$keyVal['key']] = $keyVal['val'];
      }
    }

    return $result;
  }
}

?>
