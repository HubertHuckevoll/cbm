<?php

require_once('../cbm/lb/logger.php');

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
      $fname = '/cbm/vw/'.$className.'.php';
    break;

    case 'F':
      $fname = '/cbm/vw/'.$className.'.php';
    break;

    case 'M':
      $fname = '/cbm/md/'.$className.'.php';
    break;

    case 'C':
      $fname = '/cbm/ct/'.$className.'.php';
    break;
  }

  if ($fname !== null)
  {
    $fname = $_SERVER['DOCUMENT_ROOT'].$fname;
    if (file_exists($fname))
    {
      require_once($fname);
    }
  }
});


/**
 * Project-wise Auto loader for local views
 * ________________________________________________________________
 */
spl_autoload_register(function($className)
{
  $fname = null;
  $ct = substr($className, -1);

  switch($ct)
  {
    case 'V':
      $fname = './vw/'.$className.'.php';
    break;
  }

  if (file_exists($fname))
  {
    require_once($fname);
  }

});

?>