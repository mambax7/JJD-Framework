<?php

//  ------------------------------------------------------------------------ //
/******************************************************************************


define ('_COLOR_NORMAL',   "#000000");
define ('_COLOR_SELECTED', "#FF0000");
//define ('_DELIMITEURS', "()");
define ('_DELIMITEURS', "");
//define ('_LEXCST_OTHER_NONE',      '@');
//define ('_LEXCST_MODELESELECTEUR', ' A B C ... X Y Z ');
//define ('_LEXCST_FRAMEDELIMITOR',  '#;(#);[#];{#};<#>');

******************************************************************************/

include_once (XOOPS_ROOT_PATH . "/modules/jjd_tools/_common/class/ado.php");
include_once (XOOPS_ROOT_PATH. '/modules/jjd_tools/_common/class/formatText/cls_jjd_formatText.php');

global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')
                               ."/include/jjd_constantes.php");
define ('_JJD_OTHER_NONE',      '@');
define ('_JJD_FRAMEDELIMITOR',  '#;(#);[#];{#};<#>');
define ('_JJD_COLOR_SELECTED', "#FF0000");
define ('_JJD_DELIMITEURS', "()");
define ('_JJD_MODELESELECTEUR', ' A B C ... X Y Z ');

//class cls_JJD_RIGHT extends cls_jjd_ado {  
class cls_JJD_SELECTEUR extends cls_jjd_ado  {
/************************************************************
 * declaration des variables membre:
 ************************************************************/
var $idModule  = "";
var $domaine = "";
var $tGroups = false;
  
         
/*============================================================
 * Constructucteur:
 =============================================================*/

function  __construct(){
global $xoopsConfig,$xoopsDB;
$becho = false;
  cls_jjd_ado::cls_jjd_ado($xoopsDB->prefix('jjd_selecteur'), "idSelecteur", $becho);  

  $shortName = "selecteur.php";
  //$f = XOOPS_ROOT_PATH."/modules/jjd_tools/language/{$xoopsConfig['language']}/{$shortName}";
  $f = dirname(__FILE__)."/language/{$xoopsConfig['language']}/{$shortName}";  
  
  
  if (!is_readable($f)){
    $f = XOOPS_ROOT_PATH."/modules/jjd_tools/language/english/{$shortName}";  
  }
  //echo "<hr>language<br>{$f}<hr>";
  include_once($f);
  
  return true;  
}

/*============================================================
 * methodes:
 =============================================================*/

/***********************************************************************

 ***********************************************************************/
function show_list () {
global $xoopsModule, $xoopsConfig, $xoopsDB,$xoopsOption, $xoopsUser;
//include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    

	$tpl = new XoopsTpl();
    //------------------------------------------------------
    $tl = $this->getArrays();
//displayArray($tl,"---selecteur.show_list------");
    $tpl->assign('pathToolsJS'   ,  _JJD_JS_TOOLS);  

    //-----------------------------------------------------------------    
    $tpl->assign('tSelecteurs', $tl);


    //-----------------------------------------------------------------	

    $f = dirname(__FILE__)."/templates/jjd_selecteur_list.html" ;
    //echo "<hr>$f<hr>";
	  $tpl->display( $f);
	  //$tpl->display( 'db:jjd_right.html');	  
	  //echo "<br />\n";
  

/*
*/

}

/***********************************************************************

 ***********************************************************************/
function show_fiche ($idSelecteur) {
global $xoopsModule, $xoopsConfig, $xoopsDB,$xoopsOption, $xoopsUser;
//include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");

// www\my_web_site\modules\jjd_tools\_common\images\alphabets



    
	$tpl = new XoopsTpl();
    $tpl->assign('pathToolsJS'  ,  _JJD_JS_TOOLS);  
    $tpl->assign('pathSpinJS'   ,  _JJD_JSI_SPIN);
    //echo "<hr>_JJD_JSI_SPIN<br>"._JJD_JSI_SPIN."<hr>";
    //------------------------------------------------------
    //echo "<hr>show_fiche : {$idSelecteur}<hr>";
    $selecteur = $this->getArray($idSelecteur);
    
 
    $f = _JJD_COMMON."images/alphabets/";
    $tf = getFolder ($f, '', false);
    $selecteur['lstImgFolder'] = buildHtmlListString ("fiche[imgFolder]", $tf, $selecteur['imgFolder']);

    $selecteur['lstRows'] = htmlSpin('', "fiche[rows]", $selecteur['rows'], 3, 1, 1);

    $list = array (_NO, _YES);    
    $selecteur['showAllLetters'] = getlistSearch ('fiche[showAllLetters]', $list, 0, $selecteur['showAllLetters']);

    $list = str_replace("#", _JJD_MODELESELECTEUR, _JJD_FRAMEDELIMITOR);
    $tList = explode(";", $list);
    $selecteur['listFrameDelimitor'] = getlistSearch ('fiche[frameDelimitor]', $tList, 0, $selecteur['frameDelimitor']);
/*

$selecteur['listFrameDelimitor'] =  buildHtmlListString ('fiche[frameDelimitor]', $tList, $selecteur['frameDelimitor'], 
                              false, '', $sep = ";");
*/

    
    $selecteur['spinImgScale'] = htmlSpin('', "fiche[imgScale]", $selecteur['imgScale'], 100, 0, 10);

    $selecteur['listColorSelected'] = html_colorSelecteur('fiche[colorSelected]',  $selecteur['colorSelected']);
/*
    $selecteur['lstColor'] =  html_colorSelecteur("fiche[color]", $selecteur['color']);
//$od = "onchange='showExempleSelecteur();'";
$oc = "showExempleSelecteur();";
    $selecteur['lstFontName'] = buildHtmlListString ("fiche[font]", 
                                                     _JJD_FONT_LIST, 
                                                     $selecteur['font'], 
                                                     true,$oc,",");
    $selecteur['lstFontSize'] = buildHtmlListString ("fiche[size]", 
                                                     _JJD_FONT_SIZE, 
                                                     $selecteur['size'], 
                                                     true,$oc,",");


    
    $selecteur['spiRows'] = htmlSpin("fiche[rows]", '', 
                            $selecteur['rows'], 5, 1, 1);



    $selecteur['formatSelecteur2'] = $ft->show('txtTexte2', true);   

*/
    $ft = new cls_jjd_FORMATTEXT();
    $selecteur['formatSelecteur'] = $ft->show('txtTexte', true);

//    echo buildSpin(_AD_HER_QUANTIEME, _AD_HER_QUANTIEME_DSC, 'txtJour', $p['jour'], 365, 1, 1, 10);
    
    $tt = $this->getTemplates();     
    $listTemplate = buildHtmlListString ('fiche[template]', $tt, $selecteur['template'], false, '', ";");
    $selecteur['listTemplate'] = $listTemplate;
    $selecteur['exemple'] = $this->test_01($idSelecteur, '');    
    //-----------------------------------------------------------------    
    $tpl->assign('fiche', $selecteur );

    //displayArray($selecteur,"---selecteur.show_fiche------");
    //-----------------------------------------------------------------	

    $f = dirname(__FILE__)."/templates/jjd_selecteur_fiche.html" ;
    //echo "<hr>$f<hr>";
	  $tpl->display( $f);
	  //$tpl->display( 'db:jjd_right.html');	  
	  //echo "<br />\n";
  



}

/******************************************************
 *
 ******************************************************/
function getArray ($id, $becho = 0){
	global  $xoopsDB;

  if ($id == 0) {
      $p = array ('idSelecteur'     => 0, 
                  'name'            => '',
                  'alphabet'        => 'ABCDEFGHIJKLMNOPQRSTUVWXZ',                  
                  'other'           => '#',  
                  'showAllLetters'  => 1,                  
                  'frameDelimitor'  => 0,                  
                  'letterSeparator' => '#|#',                  
                  'rows'            => 1,                  
                  'imgFolder'       => '',
                  'font'            => '',
                  'size'            => '',
                  'color'           => ''
                  );
  }
  else {
    $sqlquery = $this->getRow($id);
    $p = $xoopsDB->fetchArray($sqlquery);    


  }
  return $p;
}
/****************************************************************************
 *
 ****************************************************************************/
function newClone($id, $returnArray = false){
	global $xoopsModuleConfig, $xoopsDB, $xoopsModule;  
    
  //--------------------------------------------------------
  $sqlquery = $this->getArray($id);

  $sql = "INSERT INTO {$this->table}"
        ." (name,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,"
        .   "rows,imgFolder,font,size,color)"
        ." VALUES ("
        .sqlQuoteString($sqlquery['name']." copy({$idSelecteur})", true, true)
        .sqlQuoteString($sqlquery['alphabet'], true, true)        
        .sqlQuoteString($sqlquery['other'], true, true)        
        . $sqlquery['showAllLetters'] .','      
        . $sqlquery['frameDelimitor'] .','        
        .sqlQuoteString($sqlquery['letterSeparator'], true, true)        
        . $sqlquery['rows'] .','        
        .sqlQuoteString($sqlquery['imgFolder'], true, true)    
        .sqlQuoteString($sqlquery['font'], true, true)    
        .sqlQuoteString($sqlquery['size'], true, true)    
        .sqlQuoteString($sqlquery['color'], true, false)    
        .")" ;
  
  $xoopsDB->queryF ($sql);
  $newId = $xoopsDB->getInsertId() ;
  //echo "<hr>JJD ---{$newIdLettre}-> {$sql}<hr>"; 
         
 
  //----------------------------------------------------------
  if ($returnArray) {
    return $this->getArray($newId);
  }else{
    return $this->getRow($newId);  
  }

}
/*******************************************************************
 *
 *******************************************************************/
function saveRequest ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	   $myts =& MyTextSanitizer::getInstance();
	   // $name = $myts->makeTboxData4Show();	
  
//  displayArray($t,"----- fichier->saveRequest -----");
  //------------------------------------
  $fiche = $t['fiche'];  
  $idSelecteur = $fiche['idSelecteur'];
  //-----------------------------------------------------------
   //$t['txtCode']      = string2sql($t['txtCode']);
   //$t['txtConstant']  = string2sql($t['txtConstant']);  
    
   // $this->clean("nom = ''");
      
   //$t['txtLibelle'] = string2sql($t['txtLibelle']);
  //$texte = $t['txtLibelle'];
  $fiche['name'] = $myts->makeTareaData4Save($fiche['name']); 
    
  $fiche['name'] = sqlQuoteString($fiche['name'], false, false);
  $fiche['alphabet'] = sqlQuoteString($fiche['alphabet'], false, false);      
  $fiche['other'] = sqlQuoteString($fiche['other'], false, false);        
  $fiche['letterSeparator'] = sqlQuoteString($fiche['letterSeparator'], false, false);        
  $fiche['imgFolder'] = sqlQuoteString($fiche['imgFolder'], false, false);      
  $fiche['frameDelimitor'] = sqlQuoteString($fiche['frameDelimitor'], false, false);  
  
      
  if ($idSelecteur == 0){
      $sql = "INSERT INTO {$this->table}"
            ." (name,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,"
            .   "rows,imgFolder,imgScale,colorSelected,template)"
            ." VALUES ("
            .sqlQuoteString($fiche['name']." copy({$idLibelle})", true, true)
            .sqlQuoteString($fiche['alphabet'], true, true)        
            .sqlQuoteString($fiche['other'], true, true)        
            . $fiche['showAllLetters'] .','      
            . "'{$fiche['frameDelimitor']}',"        
            .sqlQuoteString($fiche['letterSeparator'], true, true)        
            . $fiche['rows'] .','        
            .sqlQuoteString($fiche['imgFolder'], true, true)   
            .$fiche['imgScale'].','   
            ."'{$fiche['colorSelected']}',"   
            ."'{$fiche['template']}'"     
            .")" ;
    /*

      $sql = "INSERT INTO  {$this->table} "
            ."(nom,masque,sigle)\n"
            ."VALUES (" 
            ."'{$t['txtNom']}', '{$t['txtMasque']}', '{$t['txtSigle']}'"                       
            .")";
    */
    
  }else{
    
      $sql = "UPDATE  {$this->table} SET "
           ."name             = '{$fiche['name']}',"    
           ."alphabet         = '{$fiche['alphabet']}',"    
           ."other            = '{$fiche['other']}',"    
           ."showAllLetters   = {$fiche['showAllLetters']},"    
           ."frameDelimitor   = '{$fiche['frameDelimitor']}',"    
           ."letterSeparator  = '{$fiche['letterSeparator']}',"    
           ."rows             = {$fiche['rows']},"    
           ."imgFolder        = '{$fiche['imgFolder']}',"    
           ."imgScale         = '{$fiche['imgScale']}',"    
           ."colorSelected    = '{$fiche['colorSelected']}',"    
           ."template         = '{$fiche['template']}'"    
           ." WHERE idSelecteur = ".$idSelecteur;
            
  }
  
  $xoopsDB->query($sql);           

//echo "<hr>{$sql}<hr>";
//exit;


return true;

}

/***********************************************************************
renvoi la liste des templates disponible s
 ***********************************************************************/
function getTemplates () {

  
  $f =   $f = dirname(__FILE__)."/templates/lib/";
  $t = getFiles2 ($f, false, 'html;htm;tpl', 0,  false, ';');
  //displayArray($t,"----getTemplates--{$f}-----");
  return $t;

}
	 	
/***********************************************************************
renvoi la liste des templates disponible s
 ***********************************************************************/
function getFullNameTemplate ($template) {

  
  $f =   $f = dirname(__FILE__)."/templates/lib/{$template}";
  return $f;

}

/***********************************************************************
renvoi lselecteur forate
 ***********************************************************************/
function test_01 ($idSelecteur, $url) {
Global $xoopsDB, $xoopsModuleConfig;
  
  $t = $this->GetArray($idSelecteur);
  $tpl = new XoopsTpl();
  
  //--------------------------------------------------
  //$selecteur = $t['alphabet'];
  $selecteur = $this->render($idSelecteur,
                      XOOPS_URL.'modules/lexique/index.php', 
                      12, "J", '', 
                      $xoopsDB->prefix('lex_terme'), 'name',"idLexique=1 AND state='O'",
                      "letter", "limite", '');
  
  //--------------------------------------------------  
  $tpl->assign('selecteur', $selecteur);
  
  $f =   $this->getFullNameTemplate($t['template']);
  return $tpl->fetch($f);

}
//==============================================================================
//construction du selecteur
//==============================================================================
/*********************************************************************
 *letterBar("letter.php", "letter", "limite", 0, " ", "idLexique=$idLexique", $letter,'' ,'' , $idLexique ) 
 **********************************************************************/
function render   ($idSelecteur,
                   $Link, 
                   $limite = 0, 
                   $oldLetter = "", 
                   $scriptName = "", 
                   $table = '', $colonne='',$filter='',
                   $letterParamName = "letter", 
                   $limiteParamName = "limite", 
                   $otherParams = '') {
                   


Global $xoopsDB, $xoopsModuleConfig; 

	//$t = letterBarInfo ($idLexique, ($idLexique==0)?0:2);	
	//$t = letterBarInfo ($idLexique, 2);
  $ts = $this->getArray($idSelecteur);  
  if ($ts['colorSelected'] == '') $ts['colorSelected'] = _JJD_COLOR_SELECTED;
  if ($ts['imgFolder'] <> ''){
    $ts['fullImgFolderUrl'] = _JJD_ROOT_URL."images/alphabets/" . $ts['imgFolder'] . '/';  
    $ts['fullImgFolderPath'] = _JJD_COMMON."images/alphabets/" . $ts['imgFolder'] . '/';  
    $ts['img'] = true; 
    
  }else{
    $ts['img'] = false;  
  }

  
  if ( $ts['showAllLetters'] == 0){
    $alphabet = $this->getLetterUsed ( $ts['alphabet'], $ts['other'], $table, $colonne, $filter);
  }else{
    //$alphabet =   $ts['alphabet'].((stripos($ts['alphabet'],$ts['other'])===false) ? $ts['other'] : '');
    $alphabet =   $ts['alphabet'].((stripos($ts['alphabet'],$ts['other'])===false) ? '#' : '');
    
    //if ($alphabet == ''){$alphabet = $xoopsModuleConfig['alphabet'];}  
    if ($alphabet == ''){$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';}    
  }
 

   // return letterBarUsed  ($Link, $letterParamName, $alphabet, $other, $sep, $limiteParamName, $limite, $otherParams, $oldLetter);
    if ($scriptName == ""){
        return $this->letterBarDefine($Link, $letterParamName, $alphabet, 
                                      $ts['other'], $ts['letterSeparator'], 
                                      $limiteParamName, 
                                      $limite, $otherParams, $oldLetter, $ts);  
    
    }
    else {
        return $this->letterBarDefineJS($Link, $letterParamName, $alphabet, 
                                        $ts['other'], $ts['letterSeparator'], 
                                        $limiteParamName, 
                                        $limite, $otherParams, $oldLetter, 
                                        $scriptName, $seealsoTemp, $ts);  
    
    }

}

/***************************************************************************
 *construit la liste des caracteres utilise dans le lexique.
 *Cette liste est construite a partir du premier caractere de chaque mot
 *si $other = 0 prend tous les caractFres trouves
 *si $other = 1 prend que les caracteres trouve qi se trouve dans $alphabet 
 *              et met les autres sous autres: "#"     
****************************************************************************/
function getLetterUsed($alphabet, $other, $table, $colonne, $filter){
Global $xoopsDB, $xoopsModuleConfig;

    $ta= array();
    
    if ($alphabet == ''){
        $sql = "SELECT DISTINCT  left({$colonne},1) as letter FROM {$table}"
              .(($filter == '') ? '' : " WHERE {$filter}")  
              ." ORDER BY letter" ;    
    }else if ($other <> _JJD_OTHER_NONE){
        $sql = "SELECT DISTINCT  left({$colonne},1) as letter FROM {$table}"
              ." WHERE instr('{$alphabet}',letter)> 0 "        
              .(($filter == '') ? '' : " AND {$filter}")        
              ." ORDER BY letter" ;
    }else {
        $sql = "SELECT DISTINCT  left({$colonne},1) as letter FROM {$table}"               ." WHERE idLexique= {$info['idLexique']}"
              ." WHERE instr('".$alphabet."',letter)>0 "
              ." AND letter <> '{$other}'"
              .(($filter == '') ? '' : " AND {$filter}")               
              ." ORDER BY letter" ;
    }
    
    $rst = $xoopsDB->query($sql);
    
    jjd_echo (  $sql."<br>nb enr = ".$xoopsDB->getRowsNum($rst)." -");

   	while ($sqlfetch=$xoopsDB->fetchArray($rst)) {
    		$ta[] = strtoupper( $sqlfetch['letter']);
    }  
    
    return implode('', $ta);
}

/***************************************************************************
 appelle par 'letterBar'. selon le parametre de configuration construit
 la barre de selection de l'alphabet a partir de la chaine configuree
 cela permet d'ajouter ou d'enlever des caracteres specifiques a 
 certaines langues
****************************************************************************/
function letterBarDefine($link, 
                         $letterParamName, 
                         $alphabet, 
                         $other, 
                         $separateur = " ", 
                         $limiteParamName="limite", 
                         $limite=0,
                         $otherParams = "" ,
                         $oldLetter = "", 
                         $tSelecteur ) {


//displayArray($tSelecteur,"----letterBarDefine------------------");  
  
  $ta= array();
    $debLink = "<a class='selecteur_link' href='".$link."?";
    if ($otherParams<>""){ $debLink .= $otherParams."&";};
//echo "=====>>><pre>{$separateur}</pre>";
  $this->buildDelimitors($tSelecteur, $separateur, $prefixe, $suffixe, $between);

	
  for ($i = 0; $i < strLen($alphabet) ; $i++) {
    $ltr = substr($alphabet, $i, 1);  
    if ($ltr == '#' & strlen($tSelecteur['other']) > 1) {
        $ltrlib =  $tSelecteur['other'];    
    }else{
        $ltrlib =  $this->getLettre($ltr, $tSelecteur);    
    }


    //if ($ltr == $oldLetter){ $ltrlib = "<font color='#FF0000'>".$ltr."</font>" ;}
    if ($ltr == '_'){
       $ta[$i] = $between;
       
    }else{
        if ($ltr == $oldLetter){
            $ltrlib = $this->FormaterSelection ($ltr, $tSelecteur, _JJD_DELIMITEURS) ;
        }
        
        $ta[$i]= $debLink.$letterParamName."=$ltr&".$limiteParamName."=$limite'>".$ltrlib."</a>";
    
    } 
    
  }
  //----------------------------------------------------------------------
  //   wlog(letterBarBuildString($ta, $tSelecteur)));

  return   $this->letterBarBuildString($ta, $tSelecteur);
}
/***************************************************************************
 *
****************************************************************************/

function getLettre($lettre, &$tSelecteur, $selected=false){
    if ($tSelecteur['img']){
      $name = sprintf("chr_%03d.gif", ord($lettre)) ;  //chr_048.gif
      $f = $tSelecteur['fullImgFolderPath'].$name;
      //echo ">>>{$f}<br>";   
      if ($tSelecteur['imgScale']<>0 & $tSelecteur['imgScale']<>100 ) {
        $scale = "height='{$tSelecteur['imgScale']}px'";
        $border = "style='border-style: double; border-width: 0px'";
        
      }else{
        $scale = '';
        $border = '';
      }  
      if (is_readable($f)) 
      $lettre = "<img src='{$tSelecteur['fullImgFolderUrl']}{$name}' alt='' title='' {$scale} {$border}>"; 

      
    }else{
    
    }

  return $lettre;

}
/***************************************************************************
 *
****************************************************************************/

function letterBarDefineJS($link, 
                         $letterParamName, 
                         $alphabet, 
                         $other, 
                         $separateur = " ", 
                         $limiteParamName="limite", 
                         $limite=0,
                         $otherParams = "" ,
                         $oldLetter = "", 
                         $scriptName = "", 
                         $seealsoTemp = "",
                         $tSelecteur ) {
  
  $ta= array();
//    wlog($alphabet);

  $r = "<a href='#' onclick='%0%(\"%1%\",\"%3%\");'>%2%</a>";
  $r= str_replace("%0%", $scriptName, $r);

  $debLink = $link."?";    
  if ($otherParams<>""){ $debLink .= $otherParams."&";};
  
  buildDelimitors($tSelecteur, $separateur, $prefixe, $suffixe, $between);
    
    //if ($otherParams<>""){ $alphabet .= $otherParams;}
  //-----------------------------------------------------------------	
  for ($i = 0; $i < strLen($alphabet) ; $i++) {
    $ltr = substr($alphabet, $i, 1);

    if ($ltr == '_'){
      $ta[$i] = $between;
    } 
    else{
        if ($ltr == $oldLetter){    
          $ltrlib = FormaterSelection ($ltr, $tSelecteur, _DELIMITEURS) ;
        }
        else {
          $ltrlib = $ltr ; 
        }
        //---------------------------------------------------------------------
        $newLink = $debLink.$letterParamName."=$ltr&".$limiteParamName."=".$limite;
        //$newLink = $debLink.$letterParamName."={$ltr}&toto=titi&{$limiteParamName}={$limite}";    
        
        $r2 = str_replace ("%1%", $newLink, $r);
        $r2 = str_replace ("%2%", $ltr, $r2);    
        $r2 = str_replace ("%3%", $seealsoTemp, $r2);    
        
        $ta[$i]= $r2;
    
    }
  }
  //----------------------------------------------------------------------
//    wlog(letterBarBuildString($ta,$tSelecteur));
//    wlog($alphabet);

  return   letterBarBuildString($ta, $tSelecteur);
}

/******************************************************************************
 *
 *****************************************************************************/
function buildDelimitors($tSelecteur, &$separateur, &$prefixe, &$suffixe, &$between){
  
  
  $separateur =  str_replace ("#", " ", $tSelecteur['letterSeparator']);
  
  //$delimiteur = str_replace ( '#' , ' ', $td [ $tInfoSelecteur['frameDelimitor'] ]);
  $td = explode(";", _JJD_FRAMEDELIMITOR);
  $delimiteur = str_replace ( '#' , ' ', $td[$tSelecteur['frameDelimitor']]);

    $lg = intval( (strlen($delimiteur)+1) / 2 );
    
    $prefixe = substr($delimiteur, 0, $lg);
    $suffixe = substr($delimiteur, -$lg);
    $between = $suffixe."<br>".$prefixe; 
    //--------------------------------------------
    if ($tSelecteur['img']){
      //echo "--->|{$separateur}|";
      $t = array();
      for ($h = 0; $h < strlen($separateur); $h++){
        $t[] = $this->getLettre($separateur{$h}, $tSelecteur);
      }
      $separateur = implode('', $t);
      
      $t = array();
      for ($h = 0; $h < strlen($prefixe); $h++){
        $t[] = $this->getLettre($prefixe{$h}, $tSelecteur);
      }
      $prefixe = implode('', $t);
    
      $t = array();
      for ($h = 0; $h < strlen($suffixe); $h++){
        $t[] = $this->getLettre($suffixe{$h}, $tSelecteur);
      }
      $suffixe = implode('', $t);
      
      $between = $suffixe."<br>".$prefixe; 
    }
/*
    $ts['letterSeparator'] = str_replace('#', '', $ts['letterSeparator']);
    $ts['letterSeparator'] = $this->getLettre($ts['letterSeparator'], $ts);
    
    
    $ts['leftDelimitor'] = $this->getLettre($ts['letterSeparator'], $ts); 
    $ts['leftDelimitor'] = $this->getLettre($ts['letterSeparator'], $ts); 
       
    echo "--->>>{$ts['letterSeparator']}";

*/ 

}
/******************************************************************************
 *
 *****************************************************************************/
function letterBarBuildString($ta, $tSelecteur, $color = _COLOR_NORMAL){
	Global $xoopsDB, $xoopsModuleConfig, $info;
  
    $other      = $tSelecteur['other'] ;
    $nbrows     = $tSelecteur['rows'] ;
    $limite=0;
    $this->buildDelimitors($tSelecteur, $separateur, $prefixe, $suffixe, $between);    
    //--------------------------------------------
 	  if ( $other <> _JJD_OTHER_NONE){
      //if ($nbrows < 0){$p = $between;} else {$p = '';}
   	  //$ta[] = $p."<b><a href='letter.php?letter=".$other."&limite=$limite'>"._MI_LEX_OTHER_LIB."</a></b>";
     }
     
    $nbrows = abs($nbrows);
    if ($nbrows > 1){
      $lg = intval (count($ta) / $nbrows);
      for ($i = 1; $i < $nbrows; $i++){
        $ta[$i * $lg] .= $between;
      }
    }
  
  //********************************************************************
  /*

  $letter = "<font color='".$color."'>"."<CENTER>"
            .$prefixe.implode($separateur, $ta).$suffixe
            ."</CENTER>\n"."</font>";
  */            
  $letter = $prefixe.implode($separateur, $ta).$suffixe;
            
            
  $letter = str_replace($prefixe.$separateur, $prefixe, $letter);
  $letter = str_replace($separateur.$suffixe, $suffixe, $letter);
  return $letter;

/*
    $ts['letterSeparator'] = str_replace('#', '', $ts['letterSeparator']);
    $ts['letterSeparator'] = $this->getLettre($ts['letterSeparator'], $ts);
    
    
    $ts['leftDelimitor'] = $this->getLettre($ts['letterSeparator'], $ts); 
    $ts['leftDelimitor'] = $this->getLettre($ts['letterSeparator'], $ts); 
       
    echo "--->>>{$ts['letterSeparator']}";

*/ 
}

/******************************************************************************
 *
 *****************************************************************************/
function FormaterSelection ($lettre, $tSelecteur, $delimiteurs = _DELIMITEURS){
  if (substr ($color,0,1)<>"#") {$color = "#".$color;}
  //_COLOR_SELECTED
  
  switch (strlen($delimiteurs)){
  case 0:
    $delimiteurOuvrant = "";
    $delimiteurFermant = "";
    break;
    
  case 1:
    $delimiteurOuvrant = $delimiteurs;
    $delimiteurFermant = $delimiteurs;
    break;
    
  default:
    $delimiteurOuvrant = substr($delimiteurs, 0, 1);
    $delimiteurFermant = substr($delimiteurs, 1, 1);
    break;
  }
  
  
  //$ltrlib = "<font color='".$color."'>".$delimiteurOuvrant.$ltr.$delimiteurFermant."</font>" ;
  if ($tSelecteur['img']){
    $lettre = $this->getLettre($lettre, $tSelecteur);
  }else{
    $lettre = $delimiteurOuvrant.$lettre.$delimiteurFermant;  
  }
  
  $ltrlib = "<span><font style='color: {$tSelecteur['color']};'>{$lettre}</font></span>" ;  
  //$ltrlib = "<span>{$delimiteurOuvrant}{$ltr}{$delimiteurFermant}</span>" ;  
  return $ltrlib;
  
}

//==============================================================================
} // fin de la classe



?>

