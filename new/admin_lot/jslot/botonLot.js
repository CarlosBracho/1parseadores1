$(document).keydown(function(tecla){
	switch(tecla.keyCode) {
		case 84:
			java_triter();
			break;
		case 80:
			java_permuta();
			break;
		case 83:
			java_serie();
			break;		 		 
		case 65:
			java_termiauto();
			break;
		case 71:
			java_seguidilla();
			break;
		case 82:
			java_terminal(); 
			break;
		case 107:
			var el = document.getElementById('todasninguna');
			document.getElementById('todasninguna').checked = "checked";
			xGrupo(el, 1); 
			break;
		case 109:
			var el = document.getElementById('todasninguna');
			document.getElementById('todasninguna').checked = false;
			xGrupo(el, 1);
			break;		 
		case 111: 
			imprimeTicket();
			break;	
	}
});
