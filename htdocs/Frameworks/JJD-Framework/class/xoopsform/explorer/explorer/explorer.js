

/**************************************************************
 *
 ***************************************************************/
  
var clsExplorer = function (jsap)
{                         
  
  
  	if ( typeof clsExplorer.initialized == "undefined" ) 
    {
  		clsExplorer.prototype.exist = function() {
  			//alert("Oui j'existe");
  			return true;
  		}
      /*******************************************************
       *
       ********************************************************/ 
      clsExplorer.prototype.init = function (){
        this.getObjects();
      }
      /****************************************************************************
       * Fonction d'affichage de valeur pour debugage
       * ca evite d'uttiliser la fonction "alert" qui est parfois génante
       * surtout sur l'evennement mouseover par exemple  
       ***************************************************************************/
       clsExplorer.prototype.debug = function (message) {
        if (!this.ob.debug){
          this.ob.debug = document.createElement("div");
          this.ob.debug.id = 'debug';
          this.ob.debug.className  = 'notation_debug';
          document.body.appendChild(this.ob.debug);
        }
        this.ob.debug.innerHTML = this.clName + "<br>" + message;
        //alert(message);
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsExplorer.prototype.getObjects = function (){
        //if(this.ob.note!=null) return true;
        
        keys= new Array('component','img0','img1','img2',
                        'bulle','libAverage','masque');
      
        this.ob = new Array();
        //alert('getObjects : ' + this.jsap.name);
        this.ob.note = document.getElementById(this.jsap.name);
        
        for (h=0; h<keys.length; h++){
          id = this.jsap.name + '[' + keys[h] + ']';
          this.ob[keys[h]] = document.getElementById(id);
        }
        
        if(this.ob.masque){
          this.ob.masque.style.left='0px';
          this.ob.masque.style.top='0px';
        }
        
//         for (i in this.ob)
//         {
//            //if (this.ob[i]) alert(this.ob[i].id);
//            //alert(i);
//         }
        return true;  
      }

///////////////////////////////////////////////////////
/**************************************************************
 *inputName : nom de la zone de texte qui contient le nom de l'image qui sert d'id
 **************************************************************/
function open(inputName){
  
  urlPHP = dialog_getUrlPHP(inputName);
  dialog_multi =  document.getElementById(inputName + "_multi").value; 
  if (dialog_multi < 1)  dialog_multi = 1;
  
  
  //Affiche de la zone de fond translucide pour eviter la selection
  //d'objet sur la page d'origine
  var dialog_background = document.getElementById ('dialog_background'); 
  dialog_background.style.display ="block";
  
  //affichage de la boite de dialogue
  var dialog_box = document.getElementById('dialog_box'); 
  dialog_box.style.display ="block";
  
  //affichage de la boite de dialogue
  var dialog_title = document.getElementById('dialog_title'); 
  dialog_title.innerHTML = document.getElementById(inputName + '_title').value;
  
  //position de la boite de dialogue en tenant compte du scroll de la page d'origine
  dialog_box.style.top= (document.body.scrollTop * 1) + 50;
  
  //-----------------------------------------------------------
  //chargement des icones pour la sélection dans la boite de dialogue
  dialog_loadImg(urlPHP);
  //-----------------------------------------------------------  
  //conserve le nom de zone "input" qui recevra le nom de l'icone sélectionnée
  dialog_inputName = inputName; 
  
  //conserve l'objet input lui meme
  var obInput = document.getElementsByName (inputName);  
  dialog_input = obInput[0];
  //mise envaleur de l'icone précédemment selection dont le nom est 
  //dans lz one "input" si il y a deje eu une selection
   dialog_select = document.getElementById(dialog_input.value); 
//   if (dialog_select) {
//     dialog_select.style.borderColor = dialog_color_selected; 
//   }
  dialog_ordre = 1;
  t =  dialog_input.value.split(";");
  for (h=0; h < t.length; h++){
    dialog_img[t[h]] = dialog_ordre++;
  }
  dialog_show_selection(true);

  
  //suppression des barre de defilement pour eviter
  //le deplacement de la boite de dialogue
  document.body.style.overflow='hidden'; 
}

///////////////////////////////////////////////////////
  		clsExplorer.initialized = true;
	  }
    
  	//------------------------------------------------------------
  	this.jsap = jsap;
    if (jsap.clName){
      this.clName = jsap.clName;
    }else{
      this.clName = name.replace('[','_');
      this.clName = this.clName.replace(']','_');
    }
  	//------------------------------------------------------------
    
    this.value = jsap.value;
    
  	//------------------------------------------------------------
    
    this.debugCompteur = 0;
    this.ob = new Array();
    this.getObjects();
    this.ok = false;
//alert("init : " + this.jsap.name);
///////////////////////////////////////////////////////
} //                 fin de la classe
///////////////////////////////////////////////////////
