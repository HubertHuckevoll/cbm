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
      $fname = dirname($_SERVER['SCRIPT_FILENAME']).'/vw/php/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw/'.$className.'.php';
        if (!file_exists($fname))
        {
          $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/lb/vw/'.$className.'.php';
        }
      }
    break;

    case 'M':
      $fname = dirname($_SERVER['SCRIPT_FILENAME']).'/md/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/md/'.$className.'.php';
        if (!file_exists($fname))
        {
          $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/lb/md/'.$className.'.php';
        }
      }
    break;

    case 'C':
      $fname = dirname($_SERVER['SCRIPT_FILENAME']).'/ct/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/ct/'.$className.'.php';
        if (!file_exists($fname))
        {
          $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/lb/ct/'.$className.'.php';
        }
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