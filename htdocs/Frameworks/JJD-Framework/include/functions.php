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
function displayArray($t, $name = "", $ident = 0){
  echoArray($t, $name);  
}



/***************************************************************************
Revoie la valeur d'un bit préciser par un index dans la valeur binaire
****************************************************************************/
function isBitOk($bitIndex, $binValue){
  $b = pow(2, $bitIndex);
  $v = (($binValue &  $b) <> 0 )?1:0;
  return $v;


}

?>