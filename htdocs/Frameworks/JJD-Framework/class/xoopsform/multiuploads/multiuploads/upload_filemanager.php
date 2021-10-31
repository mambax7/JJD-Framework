<?php
//session_ID();
	session_start();
	$k = 'upload';
	$_SESSION[$k] = (isset($_SESSION[$k]) ? $_SESSION[$k] + 1 : 0 ) ;


/*
ce script est appelé par l'animation flash. 
Prenez note que si vous instanciez une session ici (session_start(); ) 
elle sera diférente de celle de la session instanciée par l'utilisateur 
affichant la page HTML contenant NAS Uploader. 
Vous ne pouvez donc pas accéder à ses variables de session personnelles 
L'exmple Upload simple lancé via javascript  vous donne un moyen de contourner 
ce problème. Tout est expliqué.

http://localhost:8102/Frameworks/JJD/root/class/xoopsform/multiuploads/multiuploads/upload_filemanager.php     	
               W:\www\Frameworks\JJD\root\class\xoopsform\multiuploads\multiuploads\upload_filemanager.php
               W:\www\Frameworks\JJD\root\class\xoopsform\multiuploads\multiuploads
*/
 //echo "zzzzzzzzz<hr>";
//$f = "../../../../../../mainfile.php";
$f = "mainfile.php";
$f = "W:/www/origami/mainfile.php";
while (!file_exists($f)){
  $f = '../' . $f;
}

// $bolOk = "non";
// for($h = 0; $h < 5; $h++){
//   $f = substr($f,3);
//   if (file_exists($f)) {
//     $bolOk = "oui";
//     break;
//   }
// }
//-----------------------------------------------------
//desactivation du mod debug
//-----------------------------------------------------  
include_once($f);
$debugErr = false;
global $xoopsLogger;
$xoopsLogger->renderingEnabled = $debugErr;
error_reporting(($debugErr) ? E_ALL : 0);
$xoopsLogger->activated = $debugErr;
//-----------------------------------------------------  


 write_log("mainfile",$f);
 write_log("xrp",XOOPS_ROOT_PATH);

        

//-----------------------------------------------------
//recuperation des variables passee dans le get
$t = explode('!', $_GET['params']);
$flashParams = array();
for ($h=0, $count=count($t); $h<$count ;$h++){
   $v = explode('=', $t[$h]);
   $$v[0] = $v[1];
   $flashParams[$v[0]] = $v[1];
}

//utilise pour debuger
//include_once(XOOPS_ROOT_PATH . "/jjd/functions.php");

//extraction des extensions autorisees dans un tableau
//Bien que pas necessaire puisque la derniere version du flah
//filtre les fichiers selectionable sur les la même lsite d'extensions
$tExtensions = explode(',', strtolower($extList));
//-----------------------------------------------------
//include du fichier de langue
//------------------------------------------------------------
//$root = XOOPS_ROOT_PATH . '/class/xoopsform/multiuploads/language/';
$root = dirname(__FILE__ );
$root = str_replace('\\', '/', $root);
$root = $root . '/language/';

//$language='french';
$lg = $root . "{$language}/main.php";
if (!is_readable($lg)){
  $language = "english";
}
$lg = $root . "{$language}/main.php";
include_once($lg);
//echo 'Fichier de langue => ' . $lg .'<br>';

//-----------------------------------------------------------------------		
  //verifie qu'il y a un fichier en telechargement		
	if (isset($_FILES["Filedata"])) {
	 if($_FILES["Filedata"]['error'] == 0){ 
	    $fileDataName = $_FILES['Filedata']['name'];
	   	$tabfile = explode('.',  $fileDataName);
			$nomfile = $tabfile[0];
			
			//recupe de l'extension avec la casse, elle sera utilisee
			//si necessaire pour renomer si un fichier existe déjà et si overWrite=2
			$extfi = $tabfile[count($tabfile)-1];
			$shortName = substr($fileDataName, 0,  strlen($fileDataName)-strlen($extfi)-1); 
       
			$save_path = XOOPS_ROOT_PATH  . $dossierup .'/';		
 
     $f = $save_path . $fileDataName;
	   $b = file_exists($f);		
  	
  	//test si l'extensions est autorisee
  	//Avec la deniere version du composant c'est normalement inutile
    if (!in_array(strtolower($extfi), $tExtensions)){
       $msg =  _MU_AM_ERR_FILE_NOT_VALID;
       
    //Test si un fichier de meme nom xiste deja et si overwrite=1
    }elseif ($b && $overwrite==0) {
       //c'est lecas , defini le message de retour
       $msg =  _MU_AM_ERR_FILE_EXIST;
    } else {
		
	 // pas vraiment utile la copie fait un overwrite automatique
   //if ($b) unlink ($f);    
    
    //le fichier existant n'est pas ecrase, 
    //il est telecharge avec un autre nom en ajoutant un random
    if ($b && $overwrite==2) {
      //un fichier porte deja ce nom n renomme le nouveau fichier
      $fileDataName = $shortName .  '_' . rand(1, 1000) . '.' . $extfi;
      $f = $save_path . $fileDataName;
    }
    //------------------------------------------------------------	
		if (move_uploaded_file($_FILES["Filedata"]["tmp_name"], $f)) {


    
			//on supprime le fichier uploadé
	    //unlink ($save_path.(($_FILES["Filedata"]["name"])));
        $msg =  '1';
          
    		//callback
    		//Si un  include a ete definit ($includePageforEachPhoto)
    		//et si la fonction existe ($function2callForEachfiles)
        //le fichier est retraité par le module qui le recoit 
        //action selon le retour de la fonction :
        //         0 : On continue sans rien faire d'autre
        //         1 : On supprime le fichier et on renvoi un message d'erreur 
        if (isset($includePageforEachPhoto)) {
          $fInc = XOOPS_ROOT_PATH . $includePageforEachPhoto;
//           $content = $fInc;
//           saveTexte2File1('toto.log', $content);
          include_once($fInc);  
    
          if (function_exists($function2callForEachfiles)){   
            $flashParams['fullName'] = $f;    
            $flashParams['fileDataName'] = $fileDataName;   
       
            $r = call_user_func($function2callForEachfiles, $flashParams); 
            if ($r != ''){
              $msg =  $r;
            }   
          }
        }
    				
	     	
	     	
	     	
	     	} else {
	     	 $msg =  _MU_AM_ERR_WRITING;
	     	}
	     	
	     	
	     	}
    //------------------------------------------------------------	
	     	
	     	
	     	
	     	
		} else {
		  switch ($_FILES["Filedata"]['error']) {
  		  case 1:   $msg =  _MU_AM_ERR_FILE_TO_BIG;  	  break;
  		  case 2:   $msg =  _MU_AM_ERR_FILE_TO_BIG;  	  break;  
  		  case 3:   $msg =  _MU_AM_ERR_FILE_UNCOMPLET;  break;
  		  case 4:   $msg =  _MU_AM_ERR_NO_FILE;         break;
  		  case 5:   $msg =  _MU_AM_ERR_UNKNOW;          break;
  		  case 6:   $msg =  _MU_AM_ERR_NO_TMP;	        break;
  		  case 7:   $msg =  _MU_AM_ERR_WRITING;  		    break;
  		  case 8:   $msg =  _MU_AM_ERR_UNCORECT;     		break;
  		  default:  $msg =  _MU_AM_ERR_UNKNOW;          break;
		  }
		}
	} else {
	  $msg = _MU_AM_ERR_NO_FILE_SEND;
	}
	

//-----------------------------------------------------------------------
   //echo utf8_encode($msg . '.');
   echo $msg . '.';
//-----------------------------------------------------------------
   function write_log($libelle="",$Message="--------------------------\n")
   {
   $bolOk = false;
  //W:\www\Frameworks\JJD\root\class\xoopsform\multiuploads\multiuploads\upload_filemanager.php
  //localhost:8102/Frameworks/JJD/root/class/xoopsform/multiuploads/multiuploads/upload_filemanager.php

   $filename = "W:/www/origami/log/multiuloads.log";
    if (!$handle = fopen($filename, 'a')) {
        if ($bolOk) echo "Impossible d'ouvrir le fichier ($filename)";
        exit;
    }

    $somecontent=$libelle . "->" . $Message ."\n";
    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
        if ($bolOk) echo "Impossible d'écrire dans le fichier ($filename)";
        exit;
    }

    if ($bolOk) echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";

    fclose($handle);
   
   
   
   }
?>
