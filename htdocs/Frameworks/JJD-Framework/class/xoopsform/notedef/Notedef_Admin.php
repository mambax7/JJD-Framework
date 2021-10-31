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

//-------------------------------------------------------------
include_once (JJD_OOPSFORM_PATH . "/notedef/notedef_ado.php");
include_once (JJD_OOPSFORM_PATH . "/notation/formnotation.php");
//-------------------------------------------------------------


/***********************************************************************/

class Notedef_Admin{

const className = 'Notedef';
const idName = 'idNotedef';
const urlBase = 'controleur.php';

//const urlAdmin = 'controleur.php?menu=PhotoWalls';

static $urlImg = '';
static $urlAdmin = '';
static $urlLink = '';


var $adoNotedef = null;
/*******************************************************************
 *
 *******************************************************************/
function __construct(){

  self::$urlAdmin = XOOPS_URL . '/modules/jjd_tools/admin/' . self::urlBase 
                  . '?menu=' . self::className . "&folder=notedef";
  self::$urlImg = XMA_URL  . '/icons/20/';
  //self::$urlLink = 'controleur.php?menu=PhotoWalls&op=%1$s&idPhotoWalls=%2$s';
  //self::$urlLink = XOOPS_URL . '/modules/jjd_tools/admin/' . self::urlBase . '?menu=Notedef&folder=notedef&op=%1$s&idNotedef=%2$s';
  //self::$urlLink = self::urlBase . '?menu=Notedef&folder=notedef&op=%1$s&idNotedef=%2$s';
  self::$urlLink = self::$urlAdmin . '&op={_op_}&idNotedef={idNotedef}';
  
 
  $this->adoNotedef = new Notedef_Ado();
}

function getIdName () {
  return self::idName;
}
function getId ($p) {
  $id = (isset($p[self::idName])) ? $p[self::idName] : 0;
  return $id;
}
/*************************************************************************
 *
 **************************************************************************/ 
function listRows () {
global $xoopsModule, $xoopsDB;
 
    
  echo _JJD_JSI_TOOLS;
  echo _JJD_JSI_SPIN;  

    $index_admin = new ModuleAdmin();
    echo $index_admin->addNavigation('Notedef');
    //$index_admin->addItemButton(_AD_JJD_NEW, buildUrlJava("admin_notedef.php?op=new",false), 'add',"");
    $index_admin->addItemButton(_AM_JJD_NEW, self::$urlAdmin . 'op=new', 'add', '');

    echo  $index_admin->renderButton('right', '');



    
//    echo $index_admin->renderIndex();
  
    //--------------------------------------------------------------           
	  //xoops_cp_header();

    //--------------------------------------------------------------           
    $t = new XoopsFormAdminTable("notedef","notedef",'','', self::$urlImg);
    $t->setbackground();
    //$t->setbackground('C8BFE7','FFAECE');

    $t->addTitle('idNotedef',   _AM_JJD_ID,   'align="center"');
    $t->addTitle('name',        _AM_JJD_NAME, 'width="300px"');
    $t->addTitle('description', _AM_JJD_DESCRIPTION);
    $t->addTitle('noteMin', _AM_JJD_NOTE_MIN,   'align="center"');
    $t->addTitle('noteMax', _AM_JJD_NOTE_MAX,   'align="center"');
    //--------------------------------------------------------    
    //$link = "admin_notedef.php?{_op_}&idNotedef={idNotedef}&name={name}";
    $link = self::$urlLink;    
    //--------------------------------------------------------    
    //$t->addLink('name', $link, JJD_OP_EDIT);
    $t->addLink('name', $link, JJD_OP_EDIT);
    //--------------------------------------------------------    
    $t->addAction('actions', $link, 'edit.gif', _AD_JJD_EDIT, JJD_OP_EDIT);
      
    $t->addAction('actions', $link, 'duplicate.gif', _AD_JJD_DUPLICATE, JJD_OP_CLONE);
    
    $t->addAction('actions', $link, 'remove.gif', _AD_JJD_DELETE, JJD_OP_REMOVE);   
    
    $t->addAction('actions', $link, 'view.gif', _AD_JJD_PREVIEW, JJ_OP_PREVIEW);   
    //-----------------------------------------------------------------------
    $t->setQueryData ($this->adoNotedef->getRows('idNotedef,name,description,noteMin,noteMax'));
    //-----------------------------------------------------------------------
    echo $t->render();
    

}


/*****************************************************************
 *
 *****************************************************************/
function edit($idNotedef, $isClone=false){
    Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;

 



  if($idNotedef == 0){
      $t = $this->adoNotedef->getArray(0);
  }else{
  		$t = $this->adoNotedef->getArray($idNotedef);
      if ($isClone){
          $idNotedef = 0;      
          $t['idNotedef']  = 0; 
          $t['name']  = $t['name'] . ' (clone)'; 
      }
   }


	   $myts =& MyTextSanitizer::getInstance();

    //------------------------------------------------  
    $ligneDeSeparation = buildHR(1, _JJD_HR_COLOR1, 2);
    //$listYesNo = aList_noYes();    
    //------------------------------------------------    
          
  //echo versionJS();
  echo _JJD_JSI_TOOLS;
//  echo _JJD_JSI_SPIN;  
  
  //============================================================
  $xfValue  = array();
  $spinFolder = 'blue_cadreV2';
  
  $form = new XoopsThemeForm("edit_fiche", 'formEdit', self::$urlAdmin, 'post', false);
  $form->setExtra('enctype="multipart/form-data"');

//   $k = 'op';
//   $xfValue[$k] = new XoopsFormHidden("fiche[{$k}]", $t[$k]);
//   $form->addElement($xfValue[$k], false);     
  //============================================================
    //---id
  $k = 'idNotedef';
  //$xfValue[$k] = new XoopsFormHidden("[fiche][{$k}]", $t[$k]);
  $xfValue[$k] = new XoopsFormHidden("fiche[{$k}]", $t[$k]);
  $form->addElement($xfValue[$k], false);     

    //---Name
  $k = 'name';
  $xfValue[$k] = new XoopsFormText(_AD_JJD_NAME, "fiche[{$k}]", 80, 80, $myts->makeTboxData4Show($t[$k], "1", "1", "1"));       
  $form->addElement($xfValue[$k], false); 
/*******************************************************/
/*******************************************************/
    //---test notation
/***
 ***/
  $k = 'star';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 4.4, 'r', 1, 9, 1,"stars","blanck.png","blue.png","grey.png");    
  $xfValue[$k]->setShowAverage(2);    
  $form->addElement($xfValue[$k], false); 
  
  $k = 'smiley';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 4.4, 'r', 1, 9, 1,"smileys"," ","yellow.gif","grey.gif");    
  $form->addElement($xfValue[$k], false); 
  
  $k = 'star2';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 8.8, 'w', 2, 9, 1,"stars");    
  $xfValue[$k]->setBackground('FEAEC8');    
  $form->addElement($xfValue[$k], false); 
  
  $k = 'rectangles3d';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 5.8, 'w', 1, 9, 0,'rectangles3d=32x14','red.png','blue.png','grey.png');    
  $xfValue[$k]->setUrl(XOOPS_URL . "/class/xoopsform/notation/modele-notation.php?idModule=99&name=togodo&idParent=8&idChild=4");  
  $xfValue[$k]->setShowAverage(2);    
  $xfValue[$k]->setBackground('FFFF80');    
  $form->addElement($xfValue[$k], false); 
  
  $k = 'default1';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 1.3, 'w', 1, 9, 1, 'default','blanck.png','green.png','yellow.png');    
  $xfValue[$k]->setShowAverage(2);    
  $xfValue[$k]->setBackground('FFFF80');  
  $xfValue[$k]->setUrl(XOOPS_URL . "/class/xoopsform/notation/modele-notation.php?values=99|togodo|8|5");  
  $form->addElement($xfValue[$k], false); 
  
  
  $k = 'default2';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 1.3,'w', 1, 9, 0);    
  $xfValue[$k]->setBackground('FFFF80');    
  $xfValue[$k]->setShowAverage(2);    
  $xfValue[$k]->setUrl(XOOPS_URL . "/class/xoopsform/notation/modele-notation.php?values=99|togodo|8|6");  
  $form->addElement($xfValue[$k], false); 
  
  $k = 'default3';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 0,'w', 0, 30, 0,null," ");    
  $xfValue[$k]->setBackground('FFFF80');    
  $xfValue[$k]->setShowAverage(2);    
  $xfValue[$k]->setUrl(XOOPS_URL . "/class/xoopsform/notation/modele-notation.php?values=99|togodo|8|7");  
  $form->addElement($xfValue[$k], false); 
  
  $k = 'rectangle_04x12';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 30,'w', 0, 100, 0, 'rectangles=04x12','blanck.png','red.png','yellow.png');    
  $xfValue[$k]->setBackground('FFFF80');    
  $xfValue[$k]->setShowAverage(2);    
  $xfValue[$k]->setUrl(XOOPS_URL . "/class/xoopsform/notation/modele-notation.php?values=99|togodo|8|8");  
  $form->addElement($xfValue[$k], false); 
  
  $k = 'pingouins';
  $xfValue[$k] = new XoopsFormNotation ($k,"test {$k}", 0,'w', 0, 5, 1, 'pingouins','','yellow.png','grey.png');    
  $xfValue[$k]->setBackground('FFFF80');    
  $xfValue[$k]->setShowAverage(2);    
  $xfValue[$k]->setCursor('pointer');    
  $xfValue[$k]->setUrl(XOOPS_URL . "/class/xoopsform/notation/modele-notation.php?values=99|togodo|8|9");  
  $form->addElement($xfValue[$k], false); 
/*******************************************************/
  

    //---description
  $k = 'description';
  //$xfValue[$k] = new XoopsFormTextArea(_AM_WAL_DESC, $k, $t[$k], 5);
  $xfValue[$k] = new XoopsFormText(_AD_JJD_DESCRIPTION, "fiche[{$k}]", 80, 80, $myts->makeTboxData4Show($t[$k], "1", "1", "1"));       
  $form->addElement($xfValue[$k], false);     

    //---min / max
/*
*/
  $k = 'noteMin';
  $xfValue[$k] = new XoopsFormSpinMap(_AD_JJD_NOTE_MIN, "fiche[{$k}]", $t[$k], 0, 9,
                               1, 0, 8, $unite='', $imgFolder=$spinFolder);
  $xfValue[$k]->setStyleBordure("background-color: #CCCCCC; border-color: #FF0000;border-radius: 4px;");
//   $xfValue[$k] = new XoopsFormSpin(_AD_JJD_NOTE_MIN, "fiche[{$k}]", $t[$k], 0, 9,
//                                1, 0, 8, $unite='', $imgFolder='');
  $form->addElement($xfValue[$k], false);     
  
  $k = 'noteMax';
  $xfValue[$k] = new XoopsFormSpinMap(_AD_JJD_NOTE_MAX, "fiche[{$k}]", $t[$k], 0, 9,
                               1, 0, 8, $unite='', $imgFolder=$spinFolder);
  $xfValue[$k]->setStyleBordure("background-color: #CCCCCC; border-color: #FF0000;border-radius: 4px;");
//   $xfValue[$k] = new XoopsFormSpin(_AD_JJD_NOTE_MAX, "fiche[{$k}]", $t[$k], 0, 9,
//                                1, 0, 8, $unite='', $imgFolder='');
  $form->addElement($xfValue[$k], false);     
    

    //---FontImg
  $k = 'fontImg';
  $xfValue[$k] = new XoopsFormText(_AD_JJD_FONT_IMG, "fiche[{$k}]", 80, 80, $myts->makeTboxData4Show($t[$k], "1", "1", "1"));       
  $form->addElement($xfValue[$k], false);     

    //---_AD_JJD_CURSEUR_IMG
  $k = 'curseurImg';
  $xfValue[$k] = new XoopsFormText(_AD_JJD_CURSEUR_IMG, "fiche[{$k}]", 80, 80, $myts->makeTboxData4Show($t[$k], "1", "1", "1"));       
  $form->addElement($xfValue[$k], false);     

/*
*/
    //---index des bandes grisees et colorées
  $k = 'curseurIndexImg0';
  $xfValue[$k] = new XoopsFormSpinMap(_AD_JJD_NOTE_MAX, "fiche[{$k}]", $t[$k], 0, 10,
                               1, 0, 8, $unite='', $imgFolder=$spinFolder);
  $xfValue[$k]->setStyleBordure("background-color: #77FF88; border-color: #00FF00;border-radius: 4px;");
  $xfValue[$k]->setDescription(_AD_JJD_IDX_IMG0_DESC);
  $form->addElement($xfValue[$k], false);     

  $k = 'curseurIndexImg1';
  $xfValue[$k] = new XoopsFormSpinMap(_AD_JJD_NOTE_MAX, "fiche[{$k}]", $t[$k], 0, 10,
                               1, 0, 8, $unite='', $imgFolder='default2');
  $xfValue[$k]->setDescription(_AD_JJD_IDX_IMG1_DESC);
  $form->addElement($xfValue[$k], false);     
  
  
  //============================================================
  //---------------------------------------------------------  
  $k = 'submit';
  $xfValue[$k] = new XoopsFormButtonTray("submit", _SEND, "submit", 'admin_notedef.php?op=list') ; 
  $form->addElement($xfValue[$k], false);     

  //---------------------------------------------------------  
  //============================================================
  echo $form->render();
  
}


/****************************************************************************
 *
 ****************************************************************************/
function preview ($idNotedef){
global $xoopsUser;


    $texte = "<hr><b>EN COURS DE DEVELOPPEMENT !<b><hr>";
    //**********************************************************************
    echo $texte;
    //**********************************************************************
    $link = "<a href='javascript:window.close();'>Close</a>";
    
		echo "<FORM ACTION='admin_notedef.php?op=list' METHOD=POST>";
    echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
        <tr valign='top'>
        <td align='center' ><input type='submit' name='cancel' value='"._CLOSE."' ></td>
        <td align='left' width='200'></td>
        </tr>";
        //<td align='center' ><input type='button' name='cancel' value='"._CLOSE."' onclick='javascript:window.close();'></td>

   echo "</form>";
  
  
  
  
}
/************************************************************************
 *
 ************************************************************************/
function submit ($p){
		$this->adoNotedef->saveRequest($p);		
}

/*******************************************************************/
} // fin de la classe Notedef_Admin_Manager

 

?>
