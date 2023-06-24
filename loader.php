<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/coins/loader.php');

/**
 * CBM Auto loader
 * ________________________________________________________________
 */
spl_autoload_register(function($className)
{
  $fname = null;

  $localFolder = dirname($_SERVER['SCRIPT_FILENAME']).'/';
  $cbmFolder = $_SERVER['DOCUMENT_ROOT'].'/cbm/';
  $ct = substr($className, -1);

  switch($ct)
  {
    case 'V':
      $fname = $localFolder.'vw/php/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $cbmFolder.'vw/'.$className.'.php';
      }
    break;

    case 'M':
      $fname = $localFolder.'md/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $cbmFolder.'md/'.$className.'.php';
      }
    break;

    case 'C':
      $fname = $localFolder.'ct/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $cbmFolder.'ct/'.$className.'.php';
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