<?php
/**
 * XoopsDoubleList element  -  double list
 *  
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @version         XoopsFormSpin v 1.2
session_start(); 
	$k = 'form';
	$_SESSION[$k] = (isset($_SESSION[$k]) ? $_SESSION[$k] + 1 : 0 ) ;
 */


defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');

/**
 * A select files
 *
 * @author 		Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @copyright JJD http:xoops.kiolo.com
 * @access 		public
 */


/*----------------------------------------------------------*/
/* set here the folder of the clas relative at the root     */
/*----------------------------------------------------------*/
// define('_FOLDER','/class/xoopsform/multiuploads');
//define('_FOLDER','/modules/photowalls/class/multiuploads');
/*----------------------------------------------------------*/

class XoopsFormMultiUploads extends XoopsFormElement
{

    /**
     * Version
     *
     * @var string
     * @access private
     */
    var $_version = 2.1;
    
    /**
     * extensionsLib
     *
     * @var string
     * @access private
     */
    var $_extensionsLib = 'Images';
    
    /**
     * extensionsList
     *
     * @var string
     * @access private
     */
    var $_extensionsList = 'jpg,gif,png,giff';
    

    /**
     * uploadFolder
     *
     * @var string
     * @access private
     */
    var $_uploadFolder = 'uploads/multiUploads';


    /**
     * btnUploadHtmlVisible
     *
     * @var bool
     * @access private
     */
    var $_btnUploadHtmlVisible = false;

    /**
     * overWrite
     *
     * @var int
     * @access private
     */
    var $_overWrite = 0;

    /**
     * redirectToAfter
     *
     * @var string
     * @access private
     */
    var $_redirectToAfter = '';
    
    /**
     * addForm
     *
     * @var bool
     * @access private
     */
    var $_addForm = true;
    
    /**
     * maxFiles
     *
     * @var int
     * @access private
     */
    var $_maxFiles = 16; 
       
    /**
     * $_maxSize
     *
     * @var int
     * @access private
     */
    var $_maxSize =  200000;  //en octet      
    
    /**
     * language
     *
     * @var string
     * @access private
     */
    var $_language = 'english';
    
    /**
     *  urlGetData
     *
     * @var string
     * @access private
     */
    var $_urlGetData = '';
    //---------------------------------------------------
    /**
     *  vars
     *
     * @var Array associatif (keys+values)
     * @access private
     */
    var $_vars = array();
    //---------------------------------------------------
    /**
     * Allow loading of javascript
     *
     * @var bool
     * @access private
     */
    static $_loadJS = true;
    
    //---------------------------------------------------
    /**
     * folder of component
     *
     * @var folder
     * @access private
     */
    static $_folder = '';

    //---------------------------------------------------
    /**
     * folder of component
     *
     * @var folder
     * @access private
     */
    var $path = '';

    //---------------------------------------------------
    /**
     * folder of component
     *
     * @var folder
     * @access private
     */
    var $url = '';






    /*---------------------------------------------------------------*/    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $libExtension Libelle des extension possible
     * @param string $extensions Liste des extnsions selectionables
     * @param string $uploadFolder Dossier de destination des fichiers telecharges
     * @param string $redirectToAfter URL de redirection a la fin du telechargement
     * @param int    $overWrite Action quand un fichier de meme nom existe deja dans le dossier
     * @param bool   $btnUploadHtmlVisible Affichage d'un bouton dans le HTML pour lancer le telechargement pas vraiment utile, il existe deja dans le flash
     *                                        
     */
    function __construct($caption, 
                           $libExtension, 
                           $extensions,
                           $uploadFolder,
                           $redirectToAfter = '',
                           $overWrite = 0,
                           $btnUploadHtmlVisible = false)
    {
  global $xoopsConfig; 
  
    $this->path = str_replace('\\', '/', dirname(__file__)) . '/multiuploads';
    $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
  
    $this->folder = substr(dirname(__FILE__ ), strlen(JJD_PATH));
    $this->folder = str_replace('\\', '/', $this->folder);
    
    
//     $this->path = str_replace('\\', '/', dirname(__file__)) . '/alphabarre';
//     $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
    
    
    
//     echo $this->folder . '<hr>';

        $this->setCaption($caption);
        //$this->setName($name);
        //if ($extensions != '') $this->setExtensions($extensions);
        if ($uploadFolder != '')  $this->setUploadFolder($uploadFolder);
        $this->setOverWrite($overWrite);
        $this->setBtnUploadHtmlVisible($btnUploadHtmlVisible);
        $this->setExtensions($libExtension, $extensions);
        $this->setRedirectToAfter ($redirectToAfter);
        //------------------------------------------------------------
        $this->_language = $xoopsConfig['language'];
//         $root = XOOPS_ROOT_PATH . $this->folder . '/language/';
//         
//         $lg = $root . "{$this->_language}/main.php";
        $lg = $this->path . "/language/{$this->_language}/main.php";
        if (!is_readable($lg)){
          $this->_language = "english";
          $lg = $this->path . "/language/{$this->_language}/main.php";
        }
        //$lg = $root . "{$this->_language}/main.php";
        include_once($lg);
        //echo '<br>'.'Fichier de langue => ' . $lg .'<br>'._MU_AM_FOR_DOWNLOAD;
        
    }
 
    /*-----------------------------------------------------------------*/
    /**
     * Set the extensions descriptioins
     *       
     * Set the optins list array (list on left) 
     *     
     * @param $extName  string : Libelle dans le browser des extensions selectionable
     *                           ex: "Fichier immages"     
     * @param $extList string : Liste des extensions selectionable separe par $sep
     *                         ex: "jpg,jpeg,jpe,gif,png,tif,tiff"
     * @param $sep string : Separateur des extensions dans $extList
     */
    function setExtensions($extName, $extList = '', $sep=',')
    {
        if ($extList=='') $extList = '*';
        
        $this->_extensionsList = $extList;
        $this->_extensionsLib =  $extName;

     }
    /*-----------------------------------------------------------------*/
    /**
     * Get the shortname of the folder to download the images
     */
    function getUploadFolder()
    {
        return $this->_uploadFolder;
    }

    /**
     * Set the shortname of the folder to download the images
     *
     * @param  $folder string
     */
    function setUploadFolder($uploadFolder)
    {
        if ($uploadFolder <> '' ) $this->_uploadFolder = $uploadFolder;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the URL to get More data, It s unused here
     */
    function getUrlGetData()
    {
        return $this->_urlGetData;
    }

    /**
     * Set the URL to get More data, It s unused here
     *
     * @param $urlGetData string
     */
    function setUrlGetData($urlGetData)
    {
        $this->_urlGetData = $urlGetData;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the action to do whhen the downlod file xiste
     */
    function getOverWrite()
    {
        return $this->_overWrite;
    }

    /**
     * Set the action to do when the downlod file exist
     *  0 = Not upload
     *  1 = upload and overWrite the file
     *  2 = upload and rename the file with random
     *                 
     * @param $overWrite int
     */
    function setOverWrite($overWrite)
    {
        $this->_overWrite = $overWrite; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get btnUploadHtmlVisible : show the HTML button to upload
     */
    function getBtnUploadHtmlVisible()
    {
        return $this->_btnUploadHtmlVisible;
    }

    /**
     * Set btnUploadHtmlVisible : show the HTML button to upload
     *
     * @param getBtnUploadHtmlVisible bool
     */
    function setBtnUploadHtmlVisible($btnUploadHtmlVisible)
    {
        $this->_btnUploadHtmlVisible = $btnUploadHtmlVisible; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get URL to redirect after the dowload is complete
     *     if empty, staut on the page
     *     Used to execute for exemple, a traitement todo when all files are ubload
     *     ex: build thumbs ogphotos.               
     */
    function getRedirectToAfter()
    {
        return $this->_redirectToAfter;
    }

    /**
     * Set URL to redirect after the dowload is complete
     *     if empty, staut on the page
     *     Used to execute for exemple, a traitement todo when all files are ubload
     *     ex: build thumbs ogphotos.               
     *
     * @param $redirectToAfter string
     */
    function setRedirectToAfter($redirectToAfter)
    {
        $this->_redirectToAfter = $redirectToAfter; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get addForm : use whith $redirectToAfter to add a form to execute the redirstion
     */
    function getAddForm()
    {
        return $this->_addForm;
    }

    /**
     * Set addForm : use whith $redirectToAfter to add a form to execute the redirstion
     *
     * @param $addForm bool
     */
    function setAddForm($addForm)
    {
        $this->_addForm = $addForm; 
    }
    /**********************************************************************/
    /**
     * Get the maximum of files to download
     */
    function getMaxFiles()
    {
        return $this->_maxFiles;
    }

    /**
     * Set the maximum of files to download
     *
     * @param $maxFiles int
     */
    function setMaxFiles($maxFiles)
    {
        $this->_maxFiles =$maxFiles ; 
    }
    /**********************************************************************/
    /**
     * Get the size maximum in octets of the file allowed
     */
    function getMaxSize()
    {
        return $this->_maxSize;
    }

    /**
     * Set the size maximum in octets of the file allowed
     *
     * @param $maxSize int 
     */
    function setMaxSize($maxSize)
    {
        $this->_maxSize =$maxSize ; 
    }
    
    /**********************************************************************/
    /**
     * Get the folder of the component
     */
    function getFolder()
    {
        return $this->_folder;
    }

    /**
     * Set the folder of the component
     *
     * @param $newFolder string 
     */
    function setFolder($newFolder)
    {
        $this->_folder = $newFolder; 
    }
    /**********************************************************************/
    /**
     * Set the page and the function to call for each photo when is loded
     * This page is include in the page upload_filemanager.php of composant
     * The function is called after the copy of file
     * May sued for add watermark for exemple, or create thumb   
     *
     * @param $includePageforEachPhoto string 
     * @param $function2callForEachPhoto string 
     */
    function setCallForEachPhoto($includePageforEachPhoto, $function2callForEachPhoto)
    {
        $this->_includePageforEachPhoto = $includePageforEachPhoto; 
        $this->_function2callForEachPhoto = $function2callForEachPhoto; 
    }
    
    /**********************************************************************/
    /**
     * Set set the variables to add in get or post
     * allow to add identifiant for exemple to use it in the "CallForEachPhoto"          
     *
     * @param mixed $vars array associatif (keys+values)  o
     *              $string  "key1=value&key2=value2&key3=value3"    
     */
    function setVars($_vars, $sep = '&')
    {
        if (is_array($_vars)){
          $this->_vars = $_vars; 
        }else{
          $tVar = explode($sep, $_vars);
          $this->_vars = array(); 
          
          for ($h=0, $ount=count($tVar); $h<$count;$h++){
              $t = explode('=', $tVar($h));
              $this->_vars[$t[0]] = $t[1]; 
          }
        }
    }

    /**********************************************************************/
    /**
     * add an item in the vars atribut
     *
     * @param key string key of array item
     * @param key mixed value of item array
     *          
     */
    function addVars($key, $val)
    {
        if (!is_array($this->_vars)) $this->_vars = array(); 
        $this->_vars[$key] = $val; 
    }
    /**********************************************************************/
    
    /**
     * Prepare HTML for output
     * Le tableau params contient les variable pour le template du composant
     * Le tableau flash contient les variables a transmettre au flash          
     *
     * @return string HTML
     */
    function render()
    {

    
    //the xoopsformdoublelist use a template 
    $template = $this->path . "/template/tplMultiUploads.html";       
    //we load all the params use in the template in an array
    $params = array();   
    $params['name'] = $this->getName();  
    $params['url'] = $this->getURL();
    $params['btnUploadHtmlVisible'] = $this->_btnUploadHtmlVisible;

    //---------------------------------------------------
    $flash = array();
    
    $flash['dossierup'] = $this->getUploadFolder();     
    $flash['overwrite'] = $this->_overWrite;     
    $flash['maxFiles'] = $this->getMaxFiles();     
    $flash['maxSize'] = $this->getMaxSize();     
    $flash['language'] = $this->_language;    
    $flash['urlFlash'] = $this->url ;//. "/application" ;  
    $flash['urlGetData'] = '';     
    $flash['urlGetData'] = $this->_urlGetData;    
    $flash['extLib'] = $this->_extensionsLib;
    $flash['extList'] = $this->_extensionsList;
    jecho($params);   
    jecho($flash);   
 
// echo ">>>{$template}<br>";
// echo ">>>{$flash['urlFlash']}<br>";
   
    if (count($this->_vars)>0){
       $flash = array_merge($flash, $this->_vars);
    }

 
 
    
    $params['flash'] = $this->getArrayToVarget($flash);    
    
    //-------------------------------------------------------
    //ajoute une balise Form pour valider le formulaire 
    //et renvoyer l'adresse specifier dans "redirect""
    $params['redirectToAfter'] = $this->getRedirectToAfter(); 
     
    if ($params['redirectToAfter'] != ''){
      $this->setAddForm(true);  
    }else{
      $this->setAddForm(false);  
    } 
    $params['addForm'] = $this->getAddForm();    
      
    //-------------------------------------------------     
    //include the template   
   include_once (XOOPS_ROOT_PATH.'/class/template.php');
   $tpl = new XoopsTpl();
   //--------------------------------------------------------
   // Assign smarty variables
   $tpl->assign('params', $params);  
    
   //--------------------------------------------------------  
   // Call template
   //$tpl->display($template);  //for test only
   $html =  $tpl->fetch($template);
   //-------------------------------------------
    return $html;
    }
    

/**************************************************************************
 * privates functions
 *************************************************************************/

/**************************************************************************
 * transform the array params in string separated by "!"
 *************************************************************************/
function getArrayToVarget($tVars, $sep='!')
{
  $t = array();
  foreach($tVars as $key => $val) {
    $t [] =  $key .'=' .$val ;
  }
  $indent = str_repeat(" ", 50);
  return  implode("'\n{$indent}+ '!", $t) . '!';    

}
/**************************************************************************
 * calcul de l'URL dossier du composant
 *************************************************************************/
function getURL (){

    //$url = XOOPS_URL . $this->folder . '/';
    $url = $this->url . '/';
    return $url;
}


/*-----------------------------------------------*/
/*---          fin de la classe               ---*/
/*-----------------------------------------------*/


}

?>
