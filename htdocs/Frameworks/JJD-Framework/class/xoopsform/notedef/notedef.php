<?php
//  ------------------------------------------------------------------------ //
//       HERMES - Module de gestion de lettre de diffusion pour XOOPS        //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module HERMES version 1.1.1pour XOOPS- Gestion de lettre de diffusion 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Créeation juin 2007
Dernière modification : septembre 2007 
******************************************************************************/


include_once ("header.php");

//include_once ('admin_interface.php');

//-----------------------------------------------------------------------------------
global $xoopsModule;
//-----------------------------------------------------------------------------------
//     echoArray($_POST,'post');
//     echoArray($_GET,'get');

//-------------------------------------------------------------
$vars = array(array('name' =>'op',         'default' => 'list'),
              array('name' =>'idNotedef',  'default' => 0),
              array('name' =>'pinochio',   'default' => false));
              
require (_JJD_JJD_PATH."include/gp_globe.php");
//require (JJD_PATH . "/include/gp_globe.php");
//-------------------------------------------------------------
include_once (JJD_OOPSFORM_PATH . "/notedef/notedef_admin.php");
//-------------------------------------------------------------

 

/************************************************************************
 *
 ************************************************************************/
$adoNotedef = new NoteDef_Ado();
$notedef =new Notedef_Admin_Manager();   

  switch($op) {
		

  case "new":
		//$adoNoteDef->saveRequest($_POST);
        $p = $adoNotedef->getArray(0);
        $notedef->edit ($p);
		break;


  case "duplicate":
		$p = $adoNotedef->getArray($idNotedef);
		$p['name'] .= " - Copy of #{$idNotedef}";
		$p['idNotedef'] = 0;
    $notedef->edit ($p);    
  	break;
  	
  case "edit":
		$p = $adoNotedef->getArray($idNotedef);
    $notedef->edit ($p);
    //redirect_header("admin_texte.php?op=edit",1,_AD_HER_ADDOK);    
		break;

  case "save":
		$adoNotedef->saveRequest($_POST);		
    redirect_header("admin_notedef.php?op=list",1,_AD_JJD_ADDOK);		
		break;



  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_JJD_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idNotedef})</b>" , _AD_JJD_NOTEDEF);            
    xoops_confirm(array('op'         => 'removeOk', 
                        'idNotedef'    => $_GET['idNotedef'] ,
                        'ok'         => 1),
                        "admin_notedef.php", $msg );
//    xoops_cp_footer();
    
    break;

  case "removeOk":
    $adoNotedef->deleteId($_POST['idNotedef']);    
    redirect_header("admin_notedef.php?op=list",1,_AD_JJD_DELETEOK);    
		break;


  case "preview":
        $notedef->preview ($id);
		break;

		
  case "list":
	default:
		$notedef->listRows ();
		break;
	  //$state = _JJD_STATE_WAIT;
    //redirect_header("admin_notedef.php?op=list",1,_AD_JJD_ADDOK);
    break;
}


   
xoops_cp_footer()

 

 
//---------------------------------------------------------------------
    



?>
