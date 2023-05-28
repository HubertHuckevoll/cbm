<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/cbm/lb/logger.php');

/**
 * CBM Auto loader
 * ________________________________________________________________
 */
spl_autoload_register(function($className)
{
  $fname = null;

  $ct = substr($className, -1);

  switch($ct)
  {
    case 'V':
      if (($className == 'articleV') ||
          ($className == 'indexV') ||
          ($className == 'pageV'))
      {
        $fname = dirname($_SERVER['SCRIPT_FILENAME']).'/vw/'.$className.'.php';
        if (!file_exists($fname))
        {
          $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw.builtIn/'.$className.'.php';
        }
      }
      else
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw/'.$className.'.php';
      }
    break;

    case 'F':
      $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw/'.$className.'.php';
    break;

    case 'M':
      $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/md/'.$className.'.php';
    break;

    case 'C':
      if (($className == 'articleC') ||
          ($className == 'indexC') ||
          ($className == 'pageC'))
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/ct.builtIn/'.$className.'.php';
      }
      else
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/ct/'.$className.'.php';
      }
    break;
  }

  if ($fname !== null)
  {
    if (file_exists($fname))
    {
      require_once($fname);
    }
  }
});

?>