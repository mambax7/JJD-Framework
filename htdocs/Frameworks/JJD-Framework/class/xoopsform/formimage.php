<?php
/**
 * XOOPS form element
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
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * A simple text field
 */
class XoopsFormImage extends XoopsFormElement
{
    
    /**
     * Initial text
     *
     * @var string
     * @access private
     */
    //var $_value;
    //var $_local_description;    
    
    var $_link = '';    
    var $_title = '';    
    var $_alt   = '';    
    var $_width = 0;    
    var $_center = 1;    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $size Size
     * @param int $maxlength Maximum length of text
     * @param string $value Initial text
     */
    //function __construct($caption , $files, $title='', $alt='')
    function __construct($caption , $name, $files, $url='', $title='', $alt='')
    {
        $this->setCaption($caption);
        $this->setName($name);
        //$this->_type = $type;   
        
        if ($url) {
          $this->setValue($url . '/' . $files);
        }else{
          $this->setValue($value);
        }                
        
    }
    
    
    /**
     * Get initial content
     *
     * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }
    
    /**
     * Get initial content
     *
     * @return int
     */
    function getWidth()
    {
        return $this->_witdh;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setWidth($value)
    {
        $this->_width = $value;
    }
    
    /**
     * Get initial content
     *
     * @return string
     */
    function getLink()
    {
        return $this->_link;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setLink($value)
    {
        $this->_link = $value;
    }
  
    /**
     * Get initial content
     *
     * @return bool
     */
    function getCenter()
    {
        return $this->_center;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setCenter($value)
    {
        $this->_center = $value;
    }
    
    
    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
      
        //$description = $this->getDescription();
        $width = ($this->_width > 0) ?  "width='{$this->_width}px'" : ''; 
        $nameid = ($this->_name) ?  "name='{$this->_name}' id='{$this->_name}'" : ''; 
        
        $htmlImg = "<img {$nameid} src='{$this->getValue()}' {$width} title='{$this->_title}' alt='{$this->_alt}' />";
        //$htmlImg = "<hr>zzz{$htmlImg}yyy<hr>"; // pour tests
        
        if($this->_link){
            $htmlImg  = "<a href='{$this->_link}'  title='{$this->_title}' alt='{$this->_alt}'>{$htmlImg}</a>";
        }

        if($this->_center){
          return "<center>".$htmlImg."</center>";
        }else{
          return $htmlImg;
        }

    }
}

?>
