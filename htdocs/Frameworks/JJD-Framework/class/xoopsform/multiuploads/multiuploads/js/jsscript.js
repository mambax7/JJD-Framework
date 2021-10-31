//lance l'upload ds flash

function goUpload(vargetgoupload) {
	//alert ('fonction JS goUplad : debut upload flash - variables GET envoyées : ' + vargetgoupload);
	//en créant la balise flash avec swfobject.js on est plus obligé de tester le navigateur
	document.getElementById('nasuploader').goUpload(vargetgoupload);
}

//function lancée par flash une fois l'up  d'un fichier fini
function Upload_File_Finished(nomfichier) {
	//alert('Fonction JS Upload_File_Finished : un upload un fichier fini : ' + nomfichier);	
}  
//function lancée par flash une fois l'up de tous les fichiers fini
function Upload_Finished(param1, param2) {
	//alert('Fonction JS Upload_Finished : upload total fini');
	//alert ('on soummet le formulaire');
	document.getElementById('form_upload').submit();
}   

//exécuté à chaque ajout d'un fichier 
function Update_File(file) {
	//alert('Fonction JS Update_File : Ajout 1 un fichier à la liste : '+ file);
	
}
   

