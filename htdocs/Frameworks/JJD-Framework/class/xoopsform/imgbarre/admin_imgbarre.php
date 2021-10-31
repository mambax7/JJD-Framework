<?php
//  ------------------------------------------------------------------------ //
//       JJD_TOOLS - test de gestion des droits                              //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                            //
//  ------------------------------------------------------------------------ //
/*
	 Field  	Type 	Charset 	Attributes 	Null 	Default 	Extra 	Action
	 idSelecteur  	bigint(12) 	--- 	  	Yes  	NULL  	auto_increment  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 name  	varchar(30) 	--- 	  	Yes  	nom du selecteur  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 alphabet  	varchar(100) 	--- 	  	Yes  	ABCDEFGHIJKLMNOPQRSTUVWXZ  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 other  	varchar(12) 	--- 	  	Yes  	#  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 showAllLetters  	tinyint(1) 	--- 	  	Yes  	1  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 frameDelimitor  	tinyint(5) 	--- 	  	Yes  	0  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 letterSeparator  	varchar(8) 	--- 	  	Yes  	#|#  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 rows  	int(1) 	--- 	  	Yes  	1  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 imgFolder  	varchar(255) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 imgScale  	int(5) 	--- 	  	Yes  	100  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 font  	varchar(30) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 size  	varchar(5) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 color  	varchar(8) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 colorSelected  	varchar(8) 	--- 	  	Yes  	FF0000  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 template  	varchar(60) 	--- 	  	Yes  	standard.html  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
*/

/***********************************************************************/

/******************************************************************************

******************************************************************************/
class Selecteur_Admin
{

const className = 'Selecteur';
const idName = 'idSelecteur';
const urlBase = 'controleur.php';

//const urlAdmin = 'controleur.php?menu=PhotoWalls';

static $urlImg = '';
static $urlAdmin = '';
static $urlLink = '';

/*******************************************************************
 *
 *******************************************************************/
function __construct(){

  self::$urlAdmin = XOOPS_URL . '/modules/jjd_tools/admin/' . self::urlBase 
                  . '?menu=' . self::className . "&folder=selecteur";
  self::$urlImg = XMA_URL  . '/icons/20/';
  self::$urlLink = self::$urlAdmin . '&op={_op_}&idSelecteur={idSelecteur}';
  
 
  //$this->adoNotedef = new Notedef_Ado();
}

function getIdName () {
  return self::idName;
}
function getId ($p) {
  $id = (isset($p[self::idName])) ? $p[self::idName] : 0;
  return $id;
}


/*****************************************************************
 *
 *****************************************************************/
function listRows(){
global $xoopsDB, $xoopsModule, $xoopsConfig ,$xoopsModuleConfig;
  
  $sql = "SELECT * FROM " . $xoopsDB->prefix("jjd_selecteur") . " ORDER BY name"; 
  $rst = $xoopsDB->queryF($sql);
  //-------------------------------------------------------------- 
  echo "<hr>{$sql}<hr>";

  $index_admin = new ModuleAdmin();
  echo $index_admin->addNavigation('Selecteur');
  //$index_admin->addItemButton(_AD_JJD_NEW, buildUrlJava("admin_notedef.php?op=new",false), 'add',"");
  $index_admin->addItemButton(_AM_JJD_NEW, self::$urlAdmin . 'op=new', 'add', '');

  echo  $index_admin->renderButton('right', '');
//   echo _JJD_JSI_TOOLS;

    $t = new XoopsFormAdminTable("selecteur","Selecteurs",'','', self::$urlImg);

    $t->addTitle('idSelecteur',   _AM_JJD_ID,   'align="center"');
    $t->addTitle('name',        _AM_JJD_NAME, 'width="300px"');
    $t->addTitle('alphabet', _AM_JJD_DESCRIPTION);
    $t->addTitle('other', 'other',   'align="center"');
    $t->addTitle('showAllLetters', 'all letter',   'align="center"');

/*
	 frameDelimitor  	tinyint(5) 	--- 	  	Yes  	0  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 letterSeparator  	varchar(8) 	--- 	  	Yes  	#|#  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 rows  	int(1) 	--- 	  	Yes  	1  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 imgFolder  	varchar(255) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 imgScale  	int(5) 	--- 	  	Yes  	100  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 font  	varchar(30) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 size  	varchar(5) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 color  	varchar(8) 	--- 	  	Yes  	NULL  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 colorSelected  	varchar(8) 	--- 	  	Yes  	FF0000  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
	 template  	varchar(60) 	--- 	  	Yes  	standard.html  	  	Change 	Drop 	Primary 	Index 	Unique 	Fulltext
*/
  
    //--------------------------------------------------------    
    $link = self::$urlLink;    
    //--------------------------------------------------------    
    $t->addLink('name', $link, JJD_OP_EDIT);
        
    //--------------------------------------------------------  
    //$t->addColumn(,,,)  
    $t->addAction('actions', $link, 'edit.gif', _AD_JJD_EDIT, JJD_OP_EDIT);
      
    $t->addAction('actions', $link, 'duplicate.gif', _AD_JJD_DUPLICATE, JJD_OP_CLONE);
    
    $t->addAction('actions', $link, 'remove.gif', _AD_JJD_DELETE, JJD_OP_REMOVE);   
    
    //$t->addAction('actions', $link, 'view.gif', _AD_JJD_PREVIEW, JJ_OP_PREVIEW);   
    
    //-----------------------------------------------------------------------
    $t->setQueryData ($rst);
    //-----------------------------------------------------------------------
    echo $t->render();
}

/*****************************************************************
 *
 *****************************************************************/
function edit($p){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  
  $ado = new cls_JJD_SELECTEUR();    
  //--------------------------------------------------------------------  

    //$ado->show_fiche($idSelecteur);
    $ado->show_fiche($p['idSelecteur']);
            
}




//-----------------------------------------------------------------
/*****************************************************************
 *
 *****************************************************************/
function save($p){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
  //echo "<hr>save_selecteur<hr>";
	$ado = new cls_JJD_selecteur();
    
    $ado->saveRequest($p);	

    
    
    
}


/*****************************************************************
 *
 *****************************************************************/
function duplicate($idSelecteur){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
  //echo "<hr>duplicate_selecteur<hr>";
	$ado = new cls_JJD_selecteur();
    
    //$ado->delete($idSelecteur);	
    return $ado->newClone($idSelecteur);
    
    
    
}
 
/*****************************************************************
 *
 *****************************************************************/
function remove($idSelecteur){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
  //echo "<hr>save_selecteur<hr>";
	$ado = new cls_JJD_selecteur();
    
    //$ado->delete($idSelecteur);	
    $ado->deleteId($idSelecteur);
    
    
    
}
/*****************************************************************
 *
 *****************************************************************/
function getNew(){
  $t = array();
  $t['idSelecteur'] = 0;
  $t['name'] = '';
  $t['alphabet'] = 'ABCDEFGHIJKLMNOPQRSTUVWXZ';
  $t['other'] = '#';
  $t['showAllLetters'] = 1;
  $t['frameDelimitor'] = 0;
  $t['letterSeparator'] = '#|#';
  $t['rows'] = 1;
  $t['imgFolder'] = '';
  $t['imgScale'] = '100';
  $t['font'] = '';
  $t['size'] = '';
  $t['color'] = '';
  $t['colorSelected'] = 'FF0000';
  $t['template'] = 'standard.html';
  
  return $t;
}
//---------------------------------------------------------------------
} //fin de la classe


?>




