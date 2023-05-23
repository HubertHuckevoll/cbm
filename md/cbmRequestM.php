<?php

/**
 * give us request data
 * __________________________________________________________________
 */
class cbmRequestM
{
  /**
   * get
   * ________________________________________________________________
   */
  public function get()
  {
    $reqs = [];
    $reqs = $_GET + $_POST + $this->pathInfoAssign();

    foreach($reqs as &$req)
    {
      $req = trim($req);
      $req = preg_replace("/^(content-type:|bcc:|cc:|to:|from:)/im", "", $req);
    }

    return $reqs;
  }

  /**
   * get path infos
   * ________________________________________________________________
   */
  public function pathInfoAssign()
  {
    $keyVal = [];
    $segments = [];
    $numEntrys = null;
    $pathInfo = '';

    if (isset($_SERVER['PATH_INFO']))
    {
      $pathInfo = $_SERVER['PATH_INFO'];
      $pathInfo = substr($pathInfo, 1); // PATH_INFO has a leading "/" that creates a fake first entry
      $segments = explode('/', $pathInfo);
      $numEntrys = count($segments);

      switch ($numEntrys)
      {
        case 0:
        break;
        case 1:
        break;
        case 2:
          $keyVal['mod'] = $segments[0];
          $keyVal['hook'] = $segments[1];
        break;
        case 3:
          $keyVal['mod'] = $segments[0];
          $keyVal['hook'] = $segments[1];
          $keyVal['articleBox'] = $segments[2];
        break;
        case 4:
          $keyVal['mod'] = $segments[0];
          $keyVal['hook'] = $segments[1];
          $keyVal['articleBox'] = $segments[2];
          $keyVal['articleName'] = $segments[3];
        break;
      }
    }

    return $keyVal;
  }

}

?>