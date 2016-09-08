$(document).ready(function(){
						 
	/*$('.showPanelButton').click(function(elemento){
		elemento.preventDefault();
	
		if($(this).attr("class")=="showPanelButton open"){
			$(this).removeClass().addClass("showPanelButton close");
			$(this).attr("title","Ocultar");
		}
		else{
			$(this).removeClass().addClass("showPanelButton open");
			$(this).attr("title","Desplegar");
		}
		
		$('#'+this.rel).slideToggle('slow');

	});
    */
	
	//Validaciones de campos numéricos
	$('#Plantel_latitud').numeric();
        $('#Plantel_longitud').numeric();
	$('#distancia_central').numeric();
	
	//Validación de Coordenadas
	$('#Plantel_latitud').on('blur',function(evt){
		validCoordenadas('latitud');
	});
	
	$('#Plantel_longitud').on('blur',function(evt){
		validCoordenadas('longitud');
	});
	
	$("#form_fact_proy_may").on("submit",function(evt){
		evt.preventDefault();
		registroFactibilidaPM();
	});
	
	$("#btnBuscarCoor").on("click",function(){
		showMap();
	});
	
	//showMap();

});


/**function validGrados(coord){

	if(coord == "latitud") {
		
		var grado_lat = $('#latitud_grados').val();
		
		if (grado_lat < 0) {
			latsign = -1;
		}
		absdlat = Math.abs(Math.round(grado_lat * 1000000.));
		//Math.round is used to eliminate the small error caused by rounding in the computer: 	 
		//e.g. 0.2 is not the same as 0.20000000000284       
		//Error checks      
		if (absdlat > (90 * 1000000)) {
			alert(' Los Grados de Latitud deben estar en el rango de -90 a 90 Grados. ');
			$('#latitud_grados').val('');
			$('#latitud_minutos').val('');
			$('#latitud_segundos').val('');
			document.getElementById('latitud_grados').focus;
		}
	
	}else if(coord == "longitud") {
		
		var grado_long = $('#longitud_grados').val();
	
		if (grado_long < 0) {
			lonsign = -1;
		}
		absdlon = Math.abs(Math.round(grado_long * 1000000.));
		//Math.round is used to eliminate the small error caused by rounding in the computer: 	 
		//e.g. 0.2 is not the same as 0.20000000000284       
		//Error checks      
		if (absdlon > (180 * 1000000)) {
			alert(' Los Grados de Longitud deben estar en el rango de -180 a 180 Grados. ');
			$('#longitud_grados').val('');
			$('#longitud_minutos').val('');
			$('#longitud_segundos').val('');
			document.getElementById('longitud_grados').focus;
			
		}
	}
}


function validMinutos(coord){
	
	if(coord == "latitud") {
		
		var min_lat = $('#latitud_minutos').val();
	
		min_lat = Math.abs(Math.round(min_lat * 1000000.) / 1000000);
		//integer     
		absmlat = Math.abs(Math.round(min_lat * 1000000.));
		//integer       
		//Error checks      
		if (absmlat >= (60 * 1000000)) {
		  alert(' Los Minutos de Latitud deben estar en el rango de 0 a 59 Minutos. ');
		  $('#latitud_minutos').val('');
		}
	}else if(coord == "longitud") {
		
		var min_lon = $('#longitud_minutos').val();
	
		min_lon = Math.abs(Math.round(min_lon * 1000000.) / 1000000);
		//integer     
		absmlon = Math.abs(Math.round(min_lon * 1000000.));
		//integer       
		//Error checks      
		if (absmlon >= (60 * 1000000)) {
		  alert(' Los Minutos de Longitud deben estar en el rango de 0 a 59 Minutos. ');
		  $('#longitud_minutos').val('');
		}
	}

} 

function validSegundos(coord){
	
	if(coord == "latitud") {
		
		var seg_lat = $('#latitud_segundos').val();
		
		seg_lat = Math.abs(Math.round(seg_lat * 1000000.) / 1000000);
        absslat = Math.abs(Math.round(seg_lat * 1000000.));
        // Note: kept as big integer for now, even if submitted as decimal       
        //Error checks      
        if (absslat > (59.99999999 * 1000000)) {
           alert(' 	Los Segundos de Latitud deben mayor a 0 y menor a 60 Segundos. ');
           $('#latitud_segundos').val('');
        }
		
	}else if(coord == "longitud") {
		
		var seg_lon = $('#longitud_segundos').val();
		seg_lon = Math.abs(Math.round(seg_lon * 1000000.) / 1000000);
        absslon = Math.abs(Math.round(seg_lon * 1000000.));
        // Note: kept as big integer for now, even if submitted as decimal       
        //Error checks      
        if (absslon > (59.99999999 * 1000000)) {
           alert(' 	Los Segundos de Longitud deben mayor a 0 y menor a 60 Segundos. ');
           $('#longitud_segundos').val('');
        }
		
		
	}

}**/

function validCoordenadas(coord){
	
	if(coord == "latitud") {
		
		var lat_dec = $('#Plantel_latitud').val();
		
		if(lat_dec.value < 0) { 
		
		   signlat = -1; 
		} 
		latAbs = Math.abs( Math.round(lat_dec * 1000000.)); 
		//Math.round is used to eliminate the small error caused by rounding in the computer: 
		//e.g. 0.2 is not the same as 0.20000000000284 //Error checks 
		if(latAbs > (90 * 1000000)) {
			alert(' Los Grados de Latitud deben estar en el rango de -90 a 90 Grados. ');
			$('#Plantel_latitud').val('');
 			latAbs=0;
			return false;
		}
		
		return true;
		
	}else if (coord == "longitud") {
		
		var lon_dec = $('#Plantel_longitud').val();
		
		if(lon_dec.value < 0) { 
		
		   signlat = -1; 
		} 
		latAbs = Math.abs( Math.round(lon_dec * 1000000.)); 
		//Math.round is used to eliminate the small error caused by rounding in the computer: 
		//e.g. 0.2 is not the same as 0.20000000000284 //Error checks 
		if(latAbs > (180 * 1000000)) {
			alert(' Los Grados de Longitud deben estar en el rango de -180 a 180 Grados. ');
			$('#Plantel_longitud').val('');
 			latAbs=0;
			return false;
		}
		
		return true;
	
	}
	
}

function validDecimalCoord(coord_val){
    
    var arr_coord_val = coord_val.split('.');
    var decimales;
	
	if(coord_val.length!=0){
	
		if(arr_coord_val.length==2){
			decimales = arr_coord_val[1]+"";
			if(decimales.length<5){
				//alert(decimales.length);
				return false;
			}else{
				return true;
			}
		}else{
			//alert(arr_coord_val.length);
			return false;
		}
		
	}else{
		//alert(coord_val.length);
		return true;
		
	}
}

function showMap(){
	var latitud = $("#Plantel_latitud").val();
	var longitud = $("#Plantel_longitud").val();
	validCoordWithMap(latitud, longitud, 6);	
}

function validCoordWithMap(latitud, longitud, enfoque) {
	
	//Por defecto el mapa enfoca a Venezuela
	if(latitud=="" && longitud==""){
		arr_coord = getDefaultCoord();
		latitud = arr_coord["latitud"];
		longitud = arr_coord["longitud"];
		enfoque = arr_coord["enfoque"];
	}
	
	var position = new google.maps.LatLng(latitud, longitud)
	
	var mapOptions = {
	  center: position,
	  zoom: enfoque,
	  streetViewControl: true,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	
	var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
		
	placeMarker(position, map);
	addMapListener(map);
	
}

function addMapListener(map){
	google.maps.event.clearListeners(map, 'click');
	google.maps.event.addListener(map, 'click', function(e) {
			setCoordForm(e.latLng);
			placeMarker(e.latLng, map)
	});
}

var markersArray = new Array();
var marker;

function placeMarker(position, map) {
	
	if(marker!=null){
		markersArray.push(marker);
		clearOverlays(markersArray);
	}
	
	marker = new google.maps.Marker({
	  position: position,
	  map: map
	});
	map.panTo(position);
}

function clearOverlays(markersArray) {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
  }
}


function getDefaultCoord(){
	var arr = new Array(3);
	arr["latitud"]=7.25478;
	arr["longitud"]=-66.25478;
	arr["enfoque"]=6; 
	return arr;
}

function setCoordForm(latLng){
	$("#Plantel_latitud").val(latLng.lat());
	$("#Plantel_longitud").val(latLng.lng());
}

function registroFactibilidaPM(){
	
	$('#Plantel_longitud').val($.trim($('#Plantel_longitud').val()));
	$('#Plantel_latitud').val($.trim($('#Plantel_latitud').val()));
	
	var lon_dec = $('#Plantel_longitud').val();
	var lat_dec = $('#Plantel_latitud').val();
	
	
	if(validDecimalCoord(lon_dec) && validDecimalCoord(lat_dec) && validContenidoCoordenadas())
	{
		
		var urlDir = "controlador/ctrl_confirm_proyectos_mayores.asp";
		var data = $("#form_fact_proy_may").serialize();
		var method = $("#form_fact_proy_may").attr("method");
		var divResult = "#div_result_pm";
		var withLoadingEfect = true;
		var showResultHTML = true;
		var callback = null;
		
		executeAjax(urlDir, data, method, divResult, withLoadingEfect, showResultHTML, callback);
		window.scrollTo( 0, 0 );
				
	}else{
		
		alert("Asegurese de que las coordenadas contengan al menos 2 digitos enteros y 5 digitos decimales");
		
			
	}
}

function validContenidoCoordenadas(){
		
	
	var lon_dec = $('#Plantel_longitud').val();
	var lat_dec = $('#Plantel_latitud').val();
	
	if(lon_dec != "" && lat_dec == ""){

		alert("Introduzca ambas coordenadas: Latitud y Longitud");
		return false;
						
	}
	if(lon_dec == "" && lat_dec != ""){

		alert("Introduzca ambas coordenadas: Latitud y Longitud");
		return false;
						
	}
	
	return true;				
		
}

 