<?php

/* TO CHANGE WEBSITE CONTENTS DON'T EDIT THIS FILE
   instead you should be modifying index.org
   and in general all *.org files (see orgmode.org)
   these files are then rendered serverside

   THIS PHP FILE CONTAINS NO RELEVANT CONTENT */

require_once("helpers.inc.php");

define("DYNE_DEBUG_RENDERING_TIME", false);

/* Smarty template class configuration */
if (!defined('SMARTY_DIR')) {
    define("SMARTY_DIR", "/usr/share/php/smarty/libs/"); }
if (!is_dir(constant("SMARTY_DIR")) || !require_once("smarty/Smarty.class.php")) {
    echo "SMARTY is supposed to be installed in " . constant("SMARTY_DIR") . " but is not.";
    echo "Install it or edit SMARTY_DIR in " . __FILE__;
    exit;
}


global $smarty;
$smarty = new Smarty;
$smarty->compile_check = true; 
$smarty->debugging     = false;
$smarty->caching       = 0;

$smarty->cache_dir     = "cache";
$smarty->template_dir  = "templates";
$smarty->compile_dir   = "templates_c";
$smarty->plugins_dir   = array('/usr/share/php/smarty/plugins');



$filter    = $_GET["filter"];
$generator = $_GET["generator"];
$mixer2    = $_GET["mixer2"];
$mixer3    = $_GET["mixer3"];

if( $filter || $generator || $mixer2 || $mixer3 ) { // pages selected

  if($filter) {

    $smarty->assign("page_hgroup", "<h1>Frei0r filter :: $filter</h1>");
    
    $fd = fopen("filter/$filter.html","r");
    
    if(!$fd) { $selection = NULL; }
    else {
      $selection = "filter/$filter.html";
      fclose($fd);
    }
    
  } else if($generator) {

    $smarty->assign("page_hgroup", "<h1>Frei0r generator :: $generator</h1>");
    
    $fd = fopen("generator/$generator.html","r");
    
    if(!$fd) { $selection = NULL; }
    else {
      $selection = "generator/$generator.html";
      fclose($fd);
    }

  } else if($mixer2) {

    $smarty->assign("page_hgroup", "<h1>Frei0r mixer-2 :: $mixer2</h1>");
    
    $fd = fopen("mixer2/$mixer2.html","r");
    
    if(!$fd) { $selection = NULL; }
    else {
      $selection = "mixer2/$mixer2.html";
      fclose($fd);
    }

  } else if($mixer3) {

    $smarty->assign("page_hgroup", "<h1>Frei0r mixer-3 :: $mixer3</h1>");
    
    $fd = fopen("mixer3/$mixer3.html","r");
    
    if(!$fd) { $selection = NULL; }
    else {
      $selection = "mixer3/$mixer3.html";
      fclose($fd);
    }

  }

}

if(!$selection) {
  
  $smarty->assign("page_hgroup", "<h1>Frei0r plugin gallery</h1>");
  
  $selection = "gallery-index.html";
  
}
  



$smarty->assign("page_class",  "software org-mode");

$smarty->assign("page_title",  "free video effect plugins gallery");
$smarty->assign("stylesheet", "gallery.css");

$smarty->assign("pagename","software");
$smarty->display("_header.tpl");

if(! $selection) { echo("<h3>file not found: $filter $generator</h3>");
} else { showfile($selection); }

$smarty->display("_footer.tpl");

?>
