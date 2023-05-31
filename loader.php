<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/cbm/lb/logger.php');

/**
 * FIXME
 * This function shouldn't be here.
 * Put in a trait or a base class or something
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
      $fname = dirname($_SERVER['SCRIPT_FILENAME']).'/vw/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw/'.$className.'.php';
        if (!file_exists($fname))
        {
          $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw.lib/'.$className.'.php';
        }
      }
    break;

    case 'F':
      $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/vw.lib/'.$className.'.php';
    break;

    case 'M':
      $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/md/'.$className.'.php';
    break;

    case 'C':
      $fname = dirname($_SERVER['SCRIPT_FILENAME']).'/ct/'.$className.'.php';
      if (!file_exists($fname))
      {
        $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/ct/'.$className.'.php';
        if (!file_exists($fname))
        {
          $fname = $_SERVER['DOCUMENT_ROOT'].'/cbm/ct.lib/'.$className.'.php';
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