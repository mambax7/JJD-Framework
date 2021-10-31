<?php
namespace JJD\FSO;

/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/***************************************************************************
*
*****************************************************************************/
function  loadTextFile($f){

  if (!is_readable($f)){return '';}
  
  $fp = fopen($f,'rb');
  $taille = filesize($f);
  $text = fread($fp, $taille);
  fclose($fp);
  
  
  return $text;
  
}

/**********************************************************************
 * 
 **********************************************************************/
function saveTexte2File($fullName, $content, $mod = 0777){
  $fullName = str_replace('//', '/', $fullName);  
  
  //echo "\n<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>\n";
  //buildPath(dirname($fullName));
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
}

/* ***********************

************************** */
function getFilePrefixedBy($dirname, 
                           $extensions = null, 
                           $prefix = '', 
                           $addBlanck = false, 
                           $delPrefixAnExt=false, 
                           $fullName = false)
{
    
    $dirList = \XoopsLists::getFileListByExtension($dirname, $extensions, '');
 //echo "<hr>getFilePrefixedBy : {$dirname}<hr>" ;  
    $lgPrfix = strlen($prefix);
    if ($lgPrfix > 0){
    $files = array();
        foreach($dirList as $key=>$name){
            if(substr($name, 0, strlen($prefix)) == $prefix){
                if ($delPrefixAnExt) {
                  $h = strrpos($name, '.');
                  $name = substr($name, $lgPrfix, $h - $lgPrfix);
                }
                if ($fullName){
                    $files[$name] = $dirname .'/' . $name;
                }else{
                    $files[$name] = $name;
                }
              }
        }
    }else{
        if ($fullName){
            foreach($dirList as $name){
            $files[$name] = $dirname .'/' . $name;
            }
        }else{
            $files = $dirList;
        }
    }
    if ($addBlanck) {
        $blank = array('' => '');
        return array_merge($blank, $files);
    }else{
        return $files;
    }

}

?>