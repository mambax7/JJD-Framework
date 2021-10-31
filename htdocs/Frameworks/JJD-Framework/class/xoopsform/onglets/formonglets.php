<?php
/**
 * XOOPS form checkbox compo
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
 * @since           2.0
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @author          Skalpa Keo <skalpa@xoops.org>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: formcheckbox.php 8066 2011-11-06 05:09:33Z beckmi $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');



//class XoopsFormOnglets extends XoopsFormElement
//include_once(XOOPS_ROOT_PATH . "/class/xoopsform/form_jjd.php");
//include_once(XOOPS_ROOT_PATH . "/modules/jjd_tools/_xoops/class/xoopsform/form_jjd.php");
include_once(JJD_FORM_PATH . "/form_jjd.php");
//include_once(dirname(__FILE__)."/form_jjd.php");

class XoopsFormOnglets extends Form_JJD  
{
    /**
     * onglets
     *
     * @var array
     * @access private
     */
    var $_onglets = array();


    /**
     * css
     *
     * @var string
     * @access private
     */
    var $_css = '';
    
    /**
     * modele de couleur pour les onglets
     *
     * @var string
     * @access private
     */
     
    var $_modeleCSS = '';


    var $path = '';
    var $url = '';

    /**
     * Constructor
     *
     * @param string $name
     * @param string $caption
     * @param mixed $value Either one value as a string or an array of them.
     */
    function __construct($name, $caption, $value=0, $onglets=null, $modeleCSS='')
    {
//       $this->path = str_replace('\\','/',dirname(__FILE__)) . '/onglets';
//       $this->url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $this->path);
      
      $this->path = str_replace('\\', '/', dirname(__FILE__)) . '/onglets';
      $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
      
        $this->setCaption($caption);
        $this->setName($name);
        $this->_onglets = $onglets;

        $this->setValue($value);        
        $this->setCss('onglets-default');  
              
        $this->_modeleCSS=$modeleCSS;        

        $this->setFormType('onglets');
    }
    /**
     * Get the value index of the onglet by default
     *
     * @param bool $encode To sanitizer the text?
     * @return array
     */
    function getValue()
    {
        return $this->_value;
    }

    /**
     * Set the value index of the onglet by default
     *
     * @param integer $
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Get the "css"
     *
     * @param 
     * @return string
     */
    function getCss()
    {
        return $this->_css;
    }

    /**
     * Set the "css"
     *
     * @param string $
     */
    function setCss($css)
    {
        $this->_css = $css;
    }
    
    /**
     * Get the "modeleCSS"
     *
     * @param 
     * @return string
     */
    function getModeleCSS()
    {
        return $this->_modeleCSS;
    }

    /**
     * Set the "modeleCSS"
     *
     * @param string $
     */
    function setModeleCSS($modeleCSS)
    {
        $this->_modeleCSS = $modeleCSS;
    }
    /**
     * Add an onglet 
     *
     * @param string $name of the contenair
     * @param string $caption main title, unuse for mement
     * @param string $visible status of th onglet
     * @param string $content content of DIV linked of the onglet
     * @param string $callback javascript to run then click on this onglet
     *  
     */
    function addOnglet($name, $caption, $visible = false, $content = '', $callback = ''){
      if (!is_array($this->_onglets)) $this->_onglets = array();
      
      if ($visible){
        reset($this->_onglets);
        foreach($this->_onglets as $k => $onglet) {
          $this->_onglets[$k]['visible'] = false;
        }
      }
      
      $t = array();
      $t['name'] = $name;
      $t['caption'] = $caption;
      $t['visible'] = $visible;
      $t['content'] = $content;
      $t['callback'] = $callback;
      $this->_onglets[$t['name']] = $t;
    }

    /**
     * prepare HTML for output
     *
     * @return string
     */
    
    function render()
    {
    $nameId = $this->getName();
    $tc = array();
 

    global $xoTheme;
       $xoTheme->addStylesheet($this->url . "/css/{$this->_css}.css");
       $xoTheme->addStylesheet($this->url . "/css/{$this->_modeleCSS}.css");
//echo "{$this->url}<br>";       
//       if(file_exists(XOOPS_ROOT_PATH . '/class/xoopsform/onglets/onglets/onglets-mini.js')){
//         $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/onglets/onglets/onglets-mini.js');
//       }else{
// 
//         $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/onglets/onglets.js');
//       }

       $xoTheme->addScript($this->url . '/onglets.js');
      //$this->load_js('/class/xoopsform/onglets/onglets/onglets.js');  
      
        
        $t = array();
        
        $t[] = "<div menu_onglet='0'><ul id='{$nameId}' name='{$nameId}' menu_onglet='0' modele='{$this->_modeleCSS}'>";
        //$t[] = "<div><ul id='menu'>";     
        
        $this->_onglets[$this->getValue()]['visible'] = true;
//          echo "<br>===>".$this->getValue()."<br>";
//jecho($this->_onglets,"obglets");          
                   
        reset($this->_onglets);   
        foreach($this->_onglets as $k => $onglet) {
          if (!isset($onglet['callback'])) $onglet['callback']='';
          if ($onglet['visible']){
              $class = 'menu_enabled';
          }else{
              $class = 'menu_disabled';
          }
          $t[] = "<li class='onglet' menu_onglet='0'>";
          $t[] = "<span  id='{$nameId}' name='{$nameId}[onglets][{$onglet['name']}]' onclick=\"onglets_showTitle('{$nameId}','{$onglet['name']}','{$onglet['callback']}');\""
               . " class='{$class}' modele='{$this->_modeleCSS}'>{$onglet['caption']}</span>";
          $t[] = "</li>";
        }  
        $t[] = "</ul></div>";
        
        //------------------------------------------------------------------------        
        $t[] = "<br />";        
        $t[] = "<div class='clear' ></div>";
        
        $t[] = "<div id='{$nameId}[parent]' style=''>";
        
        
        reset($this->_onglets);  
        foreach($this->_onglets as $k => $onglet) {
          if (!isset($onglet['content'])) $onglet['content']='';
          
          //if ($k == $this->getValue()){
          if ($onglet['visible']){
            $styleView = 'line-height:18px;visibility:visible;display:block;';
          }else{
            $styleView = 'line-height:18px;visibility:hidden;display:none;';
          }
          
          
          //if (isset($onglet['name'])) echo "<br>".$onglet['name']."<br>";
          //echo "<br>===>".$k."<br>";
          //$t[] = "<div name='onglet' id='onglet_{$onglet['name']}' onglet_div='0' style='{$styleView}'>";
          $t[] = "<div name='{$nameId}' id='{$nameId}[div][{$onglet['name']}]' onglet_div='0' menu_onglet='0' style='{$styleView}' modele='{$this->_modeleCSS}'>";
          $t[] = $onglet['content'];
          
          $t[] = "</div>";
         
        }
        $t[] = "</div>";
        
  //---------------------------------------------------------------------
  $html  = implode("\n", $t);
  return $html;
  
        
        
    }
/*******************************************************************
 *
 *******************************************************************/
    function render2()
    {
    $nameId = $this->getName();
    $tc = array();
 

    global $xoTheme;
       $xoTheme->addStylesheet($this->url . "/css/{$this->_css}.css");
       $xoTheme->addStylesheet($this->url . "/css/{$this->_modeleCSS}.css");
//echo "{$this->url}<br>";       
//       if(file_exists(XOOPS_ROOT_PATH . '/class/xoopsform/onglets/onglets/onglets-mini.js')){
//         $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/onglets/onglets/onglets-mini.js');
//       }else{
// 
//         $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/onglets/onglets.js');
//       }

       $xoTheme->addScript($this->url . '/onglets.js');
      //$this->load_js('/class/xoopsform/onglets/onglets/onglets.js');  
      
        
        $t = array();
        
        $t[] = "<div menu_onglet='0'><ul id='{$nameId}' name='{$nameId}' menu_onglet='0' modele='{$this->_modeleCSS}'>";
        //$t[] = "<div><ul id='menu'>";     
        
        $this->_onglets[$this->getValue()]['visible'] = true;
//          echo "<br>===>".$this->getValue()."<br>";
//jecho($this->_onglets,"obglets");          
                   
        reset($this->_onglets);
        foreach($this->_onglets as $k => $onglet) {
          if (!isset($onglet['callback'])) $onglet['callback']='';
          if ($onglet['visible']){
              $class = 'menu_enabled';
          }else{
              $class = 'menu_disabled';
          }
          $t[] = "<li class='onglet' menu_onglet='0'>";
          $t[] = "<span  id='{$nameId}[onglets][{$onglet['name']}]' name='{$nameId}' onclick=\"onglets_showTitle('{$nameId}','{$onglet['name']}','{$onglet['callback']}');\""
               . " class='{$class}' modele='{$this->_modeleCSS}'>{$onglet['caption']}</span>";
          $t[] = "</li>";
        }
        $t[] = "</ul></div>";
        
        //------------------------------------------------------------------------        
        $t[] = "<br />";        
        $t[] = "<div class='clear' ></div>";
        
        $t[] = "<div id='{$nameId}[parent]'>";
        
        
        reset($this->_onglets);  
        foreach($this->_onglets as $k => $onglet) {
          if (!isset($onglet['content'])) $onglet['content']='';
          
          //if ($k == $this->getValue()){
          if ($onglet['visible']){
            $styleView = 'visibility:visible;display:block;';
          }else{
            $styleView = 'visibility:hidden;display:none;';
          }
          
          
          //if (isset($onglet['name'])) echo "<br>".$onglet['name']."<br>";
          //echo "<br>===>".$k."<br>";
          //$t[] = "<div name='onglet' id='onglet_{$onglet['name']}' onglet_div='0' style='{$styleView}'>";
          $t[] = "<div name='{$nameId}' id='{$nameId}[div][{$onglet['name']}]' onglet_div='0' menu_onglet='0' style='{$styleView}' modele='{$this->_modeleCSS}'>";
          $t[] = $onglet['content'];
          
          $t[] = "</div>";
         
        }
        $t[] = "</div>";
        
  //---------------------------------------------------------------------
  $html  = implode("\n", $t);
  return $html;
  
        
        
    }
} // fin de la classe

//---------------------------------------------------


?>
