<?php
namespace JJD;
/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**************************************************************
 * 
 * ************************************************************/
function getSqlDate($dateVar = null, $formatSql = 'Y-m-d H:i:s', $formatFrom = 'j-m-Y H:i:s')
{//setlocale (LC_TIME, 'fr_FR.utf8','fra');
    if (is_null($dateVar)){
        $ret = date($formatSql);
    }elseif (is_array($dateVar)){
		$dateVar = strtotime($dateVar['date']) + (int)$dateVar['time'];
        $ret =  date($formatSql, $dateVar);
    }else{
		//$newDateVar = strtotime($dateVar['date']);
        //$newDateVar = \DateTime::createFromFormat('!d-m-Y',  $dateVar);
//         $newDateVar = date_parse_from_format('!d-m-Y',  $dateVar);
//         //$ret =  date_format($date, $formatSql);
//         $ret =  date($formatSql, $newDateVar->timestamp());
//         echo "<hr>getSqlDate : {$dateVar}<br>{$newDateVar}<br>{$ret}<hr>";
    //$language = $GLOBALS['xoopsConfig']['language'];

        $newDate = date_create_from_format($formatFrom, $dateVar);
        $ret = date_format($newDate, $formatSql);
        //echo "<hr>getSqlDate : {$dateVar}<br>{$ret}<hr>";
        
        //exit;
    }
    return $ret;
  }

// Convertit une date ou un timestamp en français
function dateToLocale($dateStr) 
{
//echo _CO_JJD_ENGLISH_MONTH."<br>"._CO_JJD_LOCALE_MONTH."<br>";
    $english_months = explode(',', _CO_JJD_ENGLISH_MONTH);
    $french_months = explode(',',  _CO_JJD_LOCALE_MONTH);
    return str_replace($english_months, $french_months, $dateStr);
    

}
  
/**************************************************************
 * 
 * ************************************************************/
function getDateSql2Str($dateSql, $formatSql = 'd-m-Y H:i:s')
{setlocale(LC_TIME, "fr_FR");
    $dateStr = date($formatSql, strtotime ($dateSql));
    return dateToLocale($dateStr);
}

/**************************************************************
 * 
 * ************************************************************/
function isDateBetween($dateBegin, $dateEnd, $dateBeginOk = true, $dateEndOk = true, $currentTime = null)
{
    if (is_null($currentTime)) $currentTime = time();
    if (is_string($dateBegin))  $dateBegin = strtotime($dateBegin);
    if (is_string($dateEnd))    $dateEnd   = strtotime($dateEnd);
    
    if ($dateBeginOk && $dateEndOk){
        $ret =  (($currentTime >= $dateBegin) && ($currentTime <= $dateEnd));
    }elseif ($dateBeginOk){
        $ret =  ($currentTime >= $dateBegin);
    }elseif($dateEndOk){
        $ret =  ($currentTime <= $dateEnd);
    }else{
        $ret = true;
    }
    
    
    return ($ret) ? 1 : 0 ;
}
