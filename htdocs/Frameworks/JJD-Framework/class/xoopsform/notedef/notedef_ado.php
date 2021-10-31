<?php

//  ------------------------------------------------------------------------ //
/******************************************************************************
******************************************************************************/
include_once (XOOPS_ROOT_PATH . "/modules/jjd_tools/_common/class/ado.php");

class NoteDef_Ado extends Ado {  

/************************************************************
 * declaration des variables membre:
 ************************************************************/

      
/*============================================================
 * Constructucteur:
 =============================================================*/
function  __construct($becho = 0){
  Ado::__construct(_JJD_TFN_NOTEDEF, "idNotedef", $becho); 
  
  return true;
  
}

/*============================================================
 * methodes:
 =============================================================*/
  
/******************************************************
 *
 ******************************************************/
function getArray ($id, $colList = '*', $becho = 0){
	global  $xoopsDB;

  if ($id == 0) {
      $p = array ('idNotedef'        => 0, 
                  'name'             => '',      
                  'description'      => '',      
                  'noteMin'          => 0,
                  'noteMax'          => 9,                  
                  'fontImg'          => '',
                  'curseurImg'       => '',                  
                  'curseurIndexImg0' => 0,
                  'curseurIndexImg1' => 1);

  }
  else {
    $sqlQuery = $this->getRow($id,$colList,$becho);
    $p = $xoopsDB->fetchArray($sqlQuery);
    
    $p['description']   = sql2string ($p['description']);
    
  }
  return $p;
}

/****************************************************************
 *
 ****************************************************************/

function newRow ($t) {
	
    return newEmptyRow () ;	


}
/****************************************************************
 *
 ****************************************************************/

function newEmptyRow () {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "INSERT INTO {$this->table}"
	      ." (name,description,noteMin,noteMax,fontImg,curseurImg,curseurIndexImg0,curseurIndexImg1) "
	      ." VALUES ('???','???',0,0,'','',0,0)";
	
    $xoopsDB->query($sql);	
    $newId = $xoopsDB->getInsertId() ;
    return $newId;
  
}

/*******************************************************************
 *
 *******************************************************************/
function saveRequest ($p) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	   $myts =& MyTextSanitizer::getInstance();
	   // $name = $myts->makeTboxData4Show();	
//echoArray($t);exit;
  //------------------------------------
  $t =  $p['fiche'];
  //-----------------------------------------------------------
  //-----------------------------------------------------------
   //$t['txtTexte'] = string2sql($t['txtTexte']);
   $txt = $t['description'];
   $description = $myts->makeTareaData4Save($txt);   
    
  if ($t['idNotedef'] == 0){

      $sql = "INSERT INTO {$this->table} "
            ." (name,description,noteMin,noteMax,"
            ." fontImg,curseurImg,curseurIndexImg0,curseurIndexImg1) "
            ."VALUES (" 
            ."'{$t['name']}'," 
            ."'{$description}',"
            ."{$t['noteMin']},"
            ."{$t['noteMax']},"            
            ."'{$t['fontImg']}',"  
            ."'{$t['curseurImg']}',"            
            ."{$t['curseurIndexImg0']},"
            ."{$t['curseurIndexImg1']}"       
            .")";
   
  }else{
      $sql = "UPDATE {$this->table} SET "
           ."name              = '{$t['name']}',"
           ."description       = '{$description}',"
           ."noteMin           = {$t['noteMin']},"           
           ."noteMax           = {$t['noteMax']},"           
           ."fontImg           = '{$t['fontImg']}',"
           ."curseurImg        = '{$t['curseurImg']}',"
           ."curseurIndexImg0  = {$t['curseurIndexImg0']},"
           ."curseurIndexImg1  = {$t['curseurIndexImg1']} " 
           ." WHERE idNotedef  = ".$t['idNotedef'];
          
            
  }

  $xoopsDB->queryF($sql);           
//   echoArray($t,$sql);
//   exit;


// $tFiche = print_r($p, true);
// echo "<pre>{$tFiche}</pre>";
// echo $sql.'<br />';
// exit;

}
//==============================================================================
} // fin de la classe

?>



