// JavaScript Document

function DependxUnidades(){
	var Unidades =document.getElementsByName('9_UNIDAD');//obtiene todos los radio buttons bajo el nombre de "9_UNIDAD"
	var NomUnidad;//Obtiene el valor de la unidad seleccionada
	var Dependencias =document.getElementsByName('10_DEPENDENCIA');//Obtiene todas las opciones del select
	var i;
	
	
	
	//Revisa qué unidad está seleccionada en el radio button
	for(i=0;i<Unidades.length;i++){
		if(Unidades[i].checked) {
			NomUnidad=Unidades[i].value;
		}
	}
	
	/*
	Se tomó la descición de ocultar y mostrar los campos cada vez que se hace click ya que, en caso de error no se podría regresar select y viceversa 
	*/
	if(NomUnidad === "Externo"){
		//Esconde el select y muestra el campo de texto
		document.getElementById('registro-de-proyecto-y-evidencias-de-investigacion-2-10_DEPENDENCIA').style.display='none';
		document.getElementById('registro-de-proyecto-y-evidencias-de-investigacion-2-10_DEPENDENCIA_T').style.display='';
	}else{
	
		//Esconde el campo de texto y muestra el select
		document.getElementById('registro-de-proyecto-y-evidencias-de-investigacion-2-10_DEPENDENCIA_T').style.display='none';
		document.getElementById('registro-de-proyecto-y-evidencias-de-investigacion-2-10_DEPENDENCIA').style.display='';
		
		//Habilita el select
		document.getElementById('registro-de-proyecto-y-evidencias-de-investigacion-2-10_DEPENDENCIA').disabled=false;
		
		//Muestra las dependencias de acuerdo a la unidad seleccionada
		switch(NomUnidad){
			case "Saltillo":{
				for(i=0;i<Dependencias[0].length;i++){
					if(Dependencias[0][i].getAttribute('name') === 'UNI_S'){
						Dependencias[0][i].style.display='';
					}else{
						Dependencias[0][i].style.display='none';
					}
				}
			}
			break;
			case "Torreón":{
				for(i=0;i<Dependencias[0].length;i++){
					if(Dependencias[0][i].getAttribute('name') === 'UNI_T'){
						Dependencias[0][i].style.display='';
					}else{
						Dependencias[0][i].style.display='none';
					}
				}
			}
			break;
			case "Norte":{
				for(i=0;i<Dependencias[0].length;i++){
					if(Dependencias[0][i].getAttribute('name') === 'UNI_N'){
						Dependencias[0][i].style.display='';
					}else{
						Dependencias[0][i].style.display='none';
					}
				}
			}
			break;
		}
	}
}