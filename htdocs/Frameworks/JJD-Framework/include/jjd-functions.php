<?php
namespace JJD;
/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use Xmf\Request;
use ArrayObject;
use ZipArchive;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
/***************************************************************************
JJD - 15/07/2006
Petite modif juste pour dire que c'est JJD qu'a foutu un peu le bordel
****************************************************************************/
function getCopyright() {
global $xoopsModule;

    $module_handler = &xoops_gethandler('module');
    $versioninfo = &$module_handler->get($xoopsModule->getVar('mid'));
    $v = $versioninfo->getInfo('version');
    $i = $versioninfo->getInfo('initiales');
    $n = $versioninfo->getInfo('name');

  $cr = "<a href='http://www.wakasensei.fr' target='_new'><B>{$n}</B> "
        .'Version'." {$v} "
        .'Author'." <B>{$i}</B></a>";
 
	return ($cr);
}

/**********************************************
 *
 **********************************************/
function  get_css_color($fileName = null, $addEmpty=false){
global $helper;
    if (is_null($fileName)) $fileName = JJD_PATH_CSS . "style-item-color.css";
    
    $content = file_get_contents ($fileName);

//echo "<br>{$fileName}<br>{$content}<br>";
    $tLines = explode("\n" , $content);
//echo "nbLines = " . count($tLines) . "<pre>" . print_r($tLines, true) . "</pre>";
//echo "nbLines = " . count($tLines) ;
//  echo "<pre>" . print_r($tLines, true) . "</pre>";

    //$tColors = array(XFORMS_DEFAULT => XFORMS_DEFAULT);
    $tColors = array();
    if ($addEmpty) $tColors[''] = '';
    foreach($tLines as $line){
      if(strlen($line)>0 && $line[0] == "."){
        $t = explode("-", $line);
        $color = substr($t[0],1);
        if (!array_key_exists($color, $tColors)){
            $tColors[$color] = $color;
        }
      }
    }

    return $tColors;
}

/**************************************************************
 * 
 * ************************************************************/
function unzip($zipFile, $fldDest)
{
$zip = new ZipArchive();
$zip->open($zipFile, ZipArchive::CREATE);
//$zip->extractTo('uncompressed/', 'font_files/AlegreyaSans-Light.ttf');
$zip->extractTo($fldDest);
$zip->close();
  
  }
  
/**
 * Zip a folder (include itself).
 * Usage:
 *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
 *
 * @param string $sourcePath Path of directory to be zip.
 * @param string $outZipPath Path of output zip file.
 */
function zipSimpleDir($sourcePath, $zipFilename){
    $zip = new ZipArchive();        
//    echo "<hr>{$zipFilename}<hr>";

    $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    
    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $rootPath=$sourcePath;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourcePath), RecursiveIteratorIterator::LEAVES_ONLY);
    
    foreach ($files as $name => $file)
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath));
    
        if (!$file->isDir())
        {
            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }else {
            if($relativePath !== false)
                $zip->addEmptyDir($relativePath);
        }
    }
    
    // Zip archive will be created only after closing object
    $zip->close();

}
/**
 * Zip a folder (include itself).
 * Usage:
 *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
 *
 * @param string $sourcePath Path of directory to be zip.
 * @param string $outZipPath Path of output zip file.
 */
function unZipFile($fullName, $destPath){
    $zip = new ZipArchive();
    if ($zip->open($fullName) === TRUE) {
        $zip->extractTo($destPath);
        $zip->close();
        return true;
     }else{
        return false;
     }              
}

/****************************************************************************
 * 
 ****************************************************************************/
function include_highslide($options = null){
  Global $xoTheme,$helper, $xoopsModuleConfig;

  //$xoTheme->addScript('browse.php?jquery/jquery.js');
//	$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');  
  
//   $xoTheme->addStylesheet('browse.php?Frameworks/zoom/highslide.css');
//   $xoTheme->addScript('browse.php?Frameworks/zoom/highslide.js');

//$highslide = XOOPS_ROOT_PATH . "/Frameworks/" . $helper->getConfig('highslide');  
$highslide = XOOPS_URL . "/Frameworks/" . $xoopsModuleConfig['highslide'];  
//echo "===>highslide : <hr>{$highslide}<hr>";  

  $xoTheme->addStylesheet("{$highslide}/highslide.css");
  $xoTheme->addScript("{$highslide}/highslide.js");

  //$xoTheme->addScript('browse.php?modules/slider/assets/js/highslide.js');
  $xoTheme->addScript(XOOPS_URL . '/modules/slider/assets/js/highslide.js');

  if (!is_array($options))$options = array();
  $options['graphicsDir'] = "{$highslide}/graphics/";
  \JJD\array2js('hs', $options, false, true);
//exit ("include_highslide");
}
/****************************************************************************
Genere la declaration d'un tableau en javascript
$name : nom du ta&bleau javascript
$options : tableau associatif. les clefs seront les même en javascript
$bolEcho : si true envoie directement la chaine générée dans le flux html
retour : string a envoyer dans le flus html
note : la balise script est ajoutée automatiquement
 ****************************************************************************/
function array2js($name, $options, $isNew = false, $bolEcho = false){

  $t = array();
  $t[] = "\n<script type='text/javascript'>"; 
  
  if ($isNew){
    $t[] = "{$name} = new Array()"; 
  }
  
  foreach($options as $key=>$value){
    if (is_numeric($value)){
      $t[] = "{$name}.{$key} = {$value};"; 
    }else{
      $t[] = "{$name}.{$key} = '{$value}';"; 
    }
  }
  
  $t[] = "</script>\n"; 
  
  $js = implode("\n", $t);
  if ($bolEcho) echo $js;
  
  return $js;
}



?>