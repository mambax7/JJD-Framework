
/**************************************************************
 *
 ***************************************************************/ 
function onglets_getElements2(sTag,sClassName){
  divs = document.getElementsByTagName(sTag);
  var ret = new Array();
  
  for (var i = 0, h = 0 ; i < divs.length ; ++i){
    if (divs[i].className == sClassName){
      ret[h] = divs;
      h++;
    }else{
    }
  }

}

/************************************************************************ 
 *Fonction pour résoudre le problème d'IE car celui-ci utilise l'attribut ID au lieu de NAME
 * @param tag tag de la balise HTML (ex: input, option, ...)
 * @param name nom de l'élement (<input name="le_nom_cherché" />)
 * @return tableau comprenant tous les éléments trouvés
****************************************************************************/
function onglets_getElements(parentID, tag, attributName) {
  if (parentID ==''){
  	var elem=document.getElementsByTagName(tag);
  }else{
    papa = document.getElementById(parentID);
  	var elem = papa.getElementsByTagName(tag);
  }
  
	var arr=new Array();
	for(i=0,iarr=0; i < elem.length; i++) {
		att=elem[i].getAttribute(attributName);
		//alert (att);
		if(att) {
			arr[iarr]=elem[i];
			iarr++;
		}
	}
	return arr;
}
/**************************************************************
 *
 ***************************************************************/ 
function onglets_showTitle(barreName, idOnglet, callback){
//var divAntecedent = document.getElementById('togodo');


  //alert('onglet' + idOnglet);
  //obdiv = document.getElementById('onglet' + idOnglet);
  //obdiv.style.visibility  = 'visible';
  obOng = onglets_getElements(barreName + '[parent]', 'div', 'onglet_div');
  //obOng = document.getElementsByName("onglet");
  //alert(obOng.length);
  
  for (h=0; h < obOng.length; h++){
   obOng[h].style.visibility  = 'hidden';
   obOng[h].style.display  = 'none';
 
  }
  
  //obdiv = document.getElementById('onglet_' + idOnglet);
  obdiv = document.getElementById(barreName + '[div][' + idOnglet + ']');
    
   
   
  obdiv.style.visibility  = 'visible';
  obdiv.style.display  = 'block';
  //----------------------------------------------------------
  //ca ca marche pas sous IE
  //obOng = document.getElementsByName("onglets_barre");
  //alors:
  papa = document.getElementById(barreName);
  obOng = papa.getElementsByTagName("span");
  
  for (h=0; h<obOng.length; h++){
  //alert(h + "/" + obOng.length);
    //if (obOng[h].id  == 'onglets_barre_' + idOnglet){
    //if (obOng[h].id  == barreName + '_' + idOnglet){
    if (obOng[h].id  == barreName + '[onglets][' + idOnglet + ']'){
    
      //obOng[h].setAttribute("class","menu_enabled"); 
      obOng[h].className='menu_enabled';
    }else{
      //obOng[h].setAttribute("class","menu_disabled"); 
      obOng[h].className='menu_disabled';
    }
  }

  if (callback != '') eval(callback);   
  return false;
} 

