/***
 *
 ****/
  
var clsNotation = function (){
};


/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.getObjects = function (jsRootId, keys){
  
  if (!keys) keys= new Array('outMode','component','newNote','noteMin','noteMax',
                 'caption','background',
                 'width','fullWidth','img0','img1','img2','imgWidth',
                 'bulle','round','url',
                 'libAverage','average','newAverage','showAverage',
                 'sum','count',
                 '_NOT_VALIDATE_NEW_NOTE','_NOT_NEW_AVERAGE');

  ob = new Array();
  ob.note = document.getElementById(jsRootId);
  
  for (h=0; h<keys.length; h++){
    ob[keys[h]] = document.getElementById(jsRootId + '[' + keys[h] + ']');
  }
  return ob;  
}
/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.showBulle = function (ob, jsRootId, message, x, y){

  if (!ob.bulle){
    idBulle = jsRootId + "[bulle]";  
    ob.bulle = document.createElement("div");
    ob.bulle.setAttribute("id",idBulle);
    ob.bulle.setAttribute("name",idBulle);
    ob.bulle.className  = 'notation_bulle';
    ob.bulle.style.padding  = '5px';
    ob.bulle.style.backgroundColor= '#' + ob.background.value;
    ob.bulle.style.top  = y +'px'; 
    message += " | new"
    ob.component.appendChild(ob.bulle);
  }
    ob.bulle.style.left = x +'px'; 
    ob.bulle.innerHTML = message;
}

/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.onMouseOut = function (event,jsRootId){
 
  //event.stopPropagation(); 
  ob = this.getObjects(jsRootId);
  if (ob.bulle) ob.component.removeChild(ob.bulle);
  
  if (ob.outMode.value == 'r')  return true;
  
  
  //this.jsRootId = jsRootId;
  //alert("onMouseOut : note = " + ob.note.value);
   if (ob.note.value != ob.newNote.value){
      ob.newNote.value = ob.note.value;  
      this.adjust(ob, 0);
   }
  return true;
}

/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.onClick = function (event,jsRootId){

  //event.stopPropagation(); 
  ob = this.getObjects(jsRootId);
//   ob = this.getObjects(jsRootId, 
//        new Array('outMode','component','noteMax','noteMin','background',
//                  'caption','newNote','width','background',
//                  'fullWidth','newNote','img0','img1','img2','imgWidth',
//                  'bulle'));

//   ob.note.value = ob.newNote.value;
//   this.adjust(ob, ob.note.value);  
  newNote = ob.newNote.value;
  alert("nouvelle note : " + ob.newNote.value);
  this.setNewNote(jsRootId, newNote, 1);
}
/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.onMouseMove = function (event,jsRootId){
  
  //event.stopPropagation(); 
  ob = this.getObjects(jsRootId, new Array('outMode'));
  
  switch(ob.outMode.value){
    case 'wr':  this.onMouseMove_very_old(event,jsRootId);  break;
    case 'w':   this.onMouseMove_write(event,jsRootId);     break;
    //case 'o':   this.onMouseMove_very_old(event,jsRootId);  break;
    default:    this.onMouseMove_read(event,jsRootId);      break;
  }
}
/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.onMouseMove_read = function (event,jsRootId){
  ob = this.getObjects(jsRootId);
  
   var posX = event.clientX;
   var posY = event.clientY;
   prX =  this.getLeft(ob.component) + (posX - this.getLeft(ob.component)); 
   prY =  this.getTop(ob.component); 
  //-----------------------------------------------------------  
    x = prX;
    y = prY+20;
    bulleText = ob.caption.value + " : " + ob.note.value + ' / ' + ob.noteMax.value;     // + '|' +ob.component.style.left
    this.showBulle(ob, jsRootId, bulleText, x, y);
}
/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.onMouseMove_write = function (event,jsRootId){
  ob = this.getObjects(jsRootId);
//   ob = this.getObjects(jsRootId, 
//        new Array('outMode','component','noteMax','noteMin','background',
//                  'caption','newNote','width','background',
//                  'fullWidth','newNote','img0','img1','img2','imgWidth',
//                  'bulle','round','lib_moyenne','moyenne'));


  
   var posX;
   var posY;
   posX = event.clientX;
   posY = event.clientY;
   
   prX =  event.clientX - ob.component.style.left; 
   prY = event.clientY - this.getTop(ob.component);
   var posXY = "prXY : " + prX + " x " + prY;


  //-------------------------------------------------------
    x = event.clientX;
    y = this.getTop(ob.component)+20;
    newNote = (event.clientX-this.getLeft(ob.component)) / (ob.fullWidth.value) * ob.noteMax.value;
    //newAverage = (event.clientX-this.getLeft(ob.component)) / (ob.fullWidth.value) * ob.noteMax.value;
    if (newNote > ob.noteMax.value) newNote = ob.noteMax.value*1;
    if (newNote < ob.noteMin.value) newNote = ob.noteMin.value*1;
    
    switch(ob.round.value){
      case -1:
        break;
        newNote= Math.floor(newNote)*1;
      case -2:
        newNote= Math.ceil(newNote)*1;
        break;
      default:
        newNote = newNote.toFixed(ob.round.value)*1;
        break;
    }
    ob.newNote.value = newNote;
    newAverage = (ob.sum.value*1 + ob.newNote.value*1) / (ob.count.value*1 + 1);
    ob.newAverage.value = newAverage.toFixed(1);
/***
    t = new Array();
    h = -1;
    h++; t[h] = ob.sum.value;
    h++; t[h] = ob.newNote.value;
    h++; t[h] = ob.count.value;
    h++; t[h] = ob.newAverage.value;
    lib = t.join("|");
var bulleText = ob.caption.value + " = " + ob.note.value  + " => " +  ob.newNote.value + " - Moyenne = " + newAverage + " / " + lib;

var bulleText = ob.component.getAttribute('name') + "=" + ob.note.value  + " | " +  ob.noteMax.value + " | " + newNote.toFixed(1);
 ****/    
    
var bulleText = ob._NOT_VALIDATE_NEW_NOTE.value + ob.newNote.value ;
  
  this.showBulle(ob, jsRootId, bulleText, x, y);
  //-----------------------------------------------------------------------------    
  this.adjust(ob, 1);  
}

/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.adjust = function (ob, mode){ 
//deux mode fonctionnement
// 0 : mode normale, la valeur a afficher est la moyenne en base
// 1 : mode interactif : la valeur a afficher est la nouvelle note potentielle
  
  noteMin = ob.noteMin.value;
  
  if (mode == 1){
    v = ob.newNote.value;
    if(v < noteMin) v = noteMin;
    if(v > ob.noteMax) v = ob.noteMax;
    average = ob.newAverage.value*1;
//     average = (ob.sum.value*1 + v) / (ob.count.value*1 + 1);
//     average = 12;
//     ob.newAverage.value = 12;
  }else{
    v = ob.average.value;
    if(v < noteMin) v = noteMin;
    if(v > ob.noteMax) v = ob.noteMax;
    average = ob.average.value*1;
  }
  
 //-------------------------------------------------------------- 
  vInt	= Math.floor(v);  
  vDec	= v - vInt;
  imgWidth = ob.imgWidth.value;
  
  img1WidthInt = (vInt - noteMin) * imgWidth;
  img1WidthDec = Math.floor((imgWidth * vDec)) * 1;
  img1Width = img1WidthInt + img1WidthDec;
  img2Width = ob.width.value - img1Width;
  
  //if(img2Width<=0) img2Width=0;
  grisLeft = -img1WidthDec;
  
  ob.img1.style.width = img1Width + 'px';
  ob.img2.style.width = img2Width + 'px';
  ob.img2.style.backgroundPosition = grisLeft + 'px 0px';
 //-------------------------------------------------------------- 
  
  
  
  //alert("adjust : " + ob.component.id + " = " + newAverage);
  
  if (ob.libAverage){
    if(ob.showAverage == 1){
      libelle = "&nbsp;" + average.toFixed(1);
    }else{
      libelle = "&nbsp;" + average + ' / ' + ob.noteMax.value;
    }
    ob.libAverage.innerHTML = "&nbsp;" + libelle;
    /***
   t = new Array();
    h=-1;
    h++; t[h] = ob.noteMin.value;
    h++; t[h] = ob.noteMax.value;
    h++; t[h] = ob.sum.value;
    h++; t[h] = ob.count.value;
    h++; t[h] = ob.average.value;
    h++; t[h] = ob.newAverage.value;
    h++; t[h] = average;
    ob.libAverage.innerHTML = "&nbsp;===>" + t.join("|");
     ****/    
  }
  
}

/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.getLeft = function (MyObject)
//Fonction permettant de connaître la position d'un objet
//par rapport au bord gauche de la page.
//Cet objet peut être à l'intérieur d'un autre objet.
    {
    if (MyObject.offsetParent)
        return (MyObject.offsetLeft + this.getLeft(MyObject.offsetParent));
    else
        return (MyObject.offsetLeft);
    }
/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.getTop = function (MyObject)
//Fonction permettant de connaître la position d'un objet
//par rapport au bord haut de la page.
//Cet objet peut être à l'intérieur d'un autre objet.
    {
    if (MyObject.offsetParent)
        return (MyObject.offsetTop + this.getTop(MyObject.offsetParent));
    else
        return (MyObject.offsetTop);
    }

/*******************************************************
 *
 ********************************************************/ 
clsNotation.prototype.setNewNote =	function (jsRootId, newNote, op){
    alert ("setNewNote : newNote = " + newNote);
	
    //if (!op) op = 1;
    ob = notation.getObjects(jsRootId);
    //alert(ob.url.value);
    //url = 'http://localhost:8101/x255fra/class/xoopsform/notation/notation.php?values=99_togodo_8_5_3';
    //url= ob.url.value;
    //var reg=new RegExp("%newnote%", "g");
    //url = ob.url.value.replace(reg, newNote);
    if (!ob.url) return false;
    url = ob.url.value;
    
    tParams = new Array();
    if (url.indexOf("values",0)>0){
      url +=   '_' + jsRootId + '_' + op + '_' + newNote ;
      tParams={};
    }else{
      tParams={'jsRootId':jsRootId, 'op':op, 'note':newNote};
    }
    //alert (url);

    
    alert(url);
		//$.getJSON(url, {'note':newNote,'jsRootId':jsRootId}, function(r){		
		$.getJSON(url, tParams, function(r){		
      //alert(r.join("|"));
      //alert("Votre note () a bien été enregisttrée\nLa nouvelle moyenne est de : " + r.jsRootId +  " = "  + r.noteAverage);
      //alert("Votre note (" + newNote + ") a bien été enregisttrée\nLa nouvelle moyenne est de : " + r.noteAverage);
      ob = notation.getObjects(r['jsRootId']);
      
      ob.note.value = r['noteAverage'];
      ob.average.value = r['noteAverage'];
      ob.newAverage.value = r['noteAverage'];
      ob.sum.value = r['noteSum'];
      ob.count.value = r['noteCount'];
      
      
      notation.adjust(ob, 0); 
      if (r.op==1){ 
        message = ob._NOT_NEW_AVERAGE.value.replace("%newAverage%", r['noteAverage']);
        message = message.replace("%newNote%", r['newNote']);
        alert(message);
        //alert(r['message']);
      }
        //alert(r['message'] + jsRootId +"-op=" + r.op + ' - moyenne = ' + r['noteAverage']);
		});
		return false;
	}

/*
<a onmouseover="tooltip.show('Voici une infobulle ! ', 200);" onmouseout="tooltip.hide();">Infobulle</a>
*/
/*******************************************************
 *
 ********************************************************/ 
notation = new clsNotation();


