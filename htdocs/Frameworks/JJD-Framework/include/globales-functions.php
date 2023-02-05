<?php

/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


/*******************************************************
 *
 *******************************************************/
function echoArray($t, $title='', $bExit = false){
  $tr = print_r($t,true);
  if ($title==''){
    echo "<code><pre>{$tr}</pre></code><hr>";
  }else{
    echo "<hr>{$title}<hr><code><pre>{$tr}</pre></code>";
  }
  if ($bExit) exit();
}

/*******************************************************
 *
 *******************************************************/
function displayArray($t, $title = "", $bExit = false){
  echoArray($t, $title,$bExit);  
}



/***************************************************************************
Revoie la valeur d'un bit préciser par un index dans la valeur binaire
****************************************************************************/
function isBitOk($bitIndex, $binValue){
  $b = pow(2, $bitIndex);
  $v = (($binValue &  $b) <> 0 )?1:0;
  return $v;


}

/***************************************************************************
Charge les fichiers de langues
****************************************************************************/
function loadLanguageFWJJD($file){
global $xoopsConfig;
  $root =  JJD_PATH . "/language/"; 
  $lang = $root . $xoopsConfig['language'] . "/" . $file . ".php";
//echo "<hr>lg = {$lang}<hr>";
  if (!file_exists($lang)){
    $lang = $root . "english/common.php";
  }
//echo "<hr>lg = {$lang}<hr>";
  return include_once ($lang);
  
}
?>