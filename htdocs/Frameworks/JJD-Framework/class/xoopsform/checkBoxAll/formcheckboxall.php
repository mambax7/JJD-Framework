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
 * extension of class : FormCheckBox : add options checkAll
 *   
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @since           2.0
 * @author          Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @version         $Id: formcheckboxall.php 4941 2010-07-22 17:13:36Z beckmi $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');

class XoopsFormCheckBoxAll extends XoopsFormCheckBox
{

    /**
     * Caption for otpion checkAll
     *
     * @var string
     * @access public
     */
    var $_OptionCheckAllcaption = 'All';
    
    /**
     * position for otpion checkAll
     *
     * @var int
     * @access public
     */
    var $_OptionCheckAllPos = 0;
    
    /**
     * value default (checked)
     *
     * @var bool
     * @access public
     */
    var $_OptionCheckAllDefault = flse;

    /**
     * Add an option to check all checkbox
     *
     * @param string $caption
     * @param string $pos (-1: in first, 0: none, 1:in last)
     */
    function addOptionCheckAll($caption = '', $pos=1, $checked=false)
    {
        $this->_OptionCheckAllPos = $pos;
        $this->_OptionCheckAllCaption = $caption;    
        $this->_OptionCheckAllDefault = $checked;    
    }
    
    /**
     * return optoin checkboxxAll
     *
     * private function     
     * @return string
     */
/*
*/      
    function getCheckAll($idBidon)
    {
      $ele_id = substr($this->getName(),0,-2);
      $ele_options = $this->getOptions();

      $h = 0;
      reset($ele_options);
      foreach($ele_options as $value => $name) {
          $h++;
          $t[] = "'" . $ele_id . $h . "'";
      }
      $ids = implode(',', $t);
      
      $event = "onclick=\""
             . "var optionids = new Array({$ids});"
             . "xoopsCheckAllElements(optionids, '{$idBidon}');\" "; 
      
      return $event;
    }
    
    
    
    
    
    
    /**
     * prepare HTML for output
     *
     * @return string
     */
    function render()
    {
        //--- JJD
        $idBidon = 'chkAll_' . rand(1,999999) ;
        
        switch ($this->_OptionCheckAllPos){
          case 1:
            //Ajout de l'option 'tout' en fin de liste
            $this->addOption($idBidon, $this->_OptionCheckAllCaption);
            $addCheckAll = true;
            break;

          case -1:
            //Ajout de l'option 'tout' en début de liste
            $t = array ($idBidon => $this->_OptionCheckAllCaption);
            $this->_options = array_merge ($t ,$this->_options);
            $addCheckAll = true;
            break;

          default:
            $addCheckAll = false;
            break;
        }  
        
        //recupe de chaine html
        $ret = XoopsFormCheckBox::render();
        
        if ($addCheckAll){
          //generation de l'evenement onclick a ajouter a idBidon
          $event = $this->getcheckAll($idBidon);
          $checked = (($this->_OptionCheckAllDefault) ? 'checked' : '');
          //recherche de la position de la checkbox "tout" grace = idBidon    
          $h = strpos($ret, $idBidon);
          $i = strpos($ret, '>', $h);
          //$j = strpos($ret, '<', $h);
          $j=0;
          $k=-1;
          while (true){
            $j = $k;
            $k = strpos($ret, '<', $k+1);
            if ($k > $i || $k === false) break;
          }
          
          //construction de la nouvelle checkBox
          $chkAll = "<input type='checkbox' name='{$idBidon}' id='{$idBidon}' "
                  . "title='' {$checked} value='' {$event} />";        
          
          //reconstruction du rendu
          $ret = substr($ret,0, $j)
               . $chkAll
               . substr($ret, $i+1);
        }
             
        
        return $ret;
    }
    

}

?>
