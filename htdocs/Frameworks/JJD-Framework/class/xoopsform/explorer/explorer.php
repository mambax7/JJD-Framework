<?PHP
class XoopsFormAlphaBarre extends XoopsObject  
{

var $version = 2.10;
var $path = '';
var $url = '';

 /*****************
  * Options d'affichage de la barre de lettres 
  *****************/  

/*============================================================
 * Constructucteur:
 =============================================================*/
//function  cls_hermes_texte($table, $colNameId, $becho = 0){
function  __construct ($root = '',  
                       $mode = 'r',
                       $patern = '*.*')
{
  //$this->init();
                      
  $this->setVar ('root', $root);
  $this->setVar ('mode', $mode);
  $this->setVar ('patern', $patern);
  
  return true;  
}

/*============================================================
 * return la liste des fichiers ou repertoires du chemi passe en parametre:
 =============================================================*/
//function  cls_hermes_texte($table, $colNameId, $becho = 0){
function  getFiles ($root = '',  
                    $mode = 'r',
                    $patern = '*.*')
{
  //$this->init();
                      
  
  return true;  
}
////////////////////////////////////////////////////////////////////
function render(){



}

} //Fin de la classe 

?>
