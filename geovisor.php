<!doctype html>
<html>
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>KISAPINCHA</title>  
    <link rel="stylesheet" type="text/css" href="themes/material/easyui.css">  
    <link rel="stylesheet" type="text/css" href="themes/mobile.css">  
    <link rel="stylesheet" type="text/css" href="themes/icon.css">  
            <link rel="stylesheet" type="text/css" href="themes/color.css">  
    <script type="text/javascript" src="js/jquery.min.js"></script>  
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script> 
    <script type="text/javascript" src="js/jquery.easyui.mobile.js"></script> 

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
   

</head>

<body> 
    <div class="easyui-layout" fit="true" >
    <?php include('encabezado.php') ?>   
        <div data-options="region:'west',split:true" title="Opciones" style="  width:200px; " >        
        <?php include('menu.php') ?>
        </div>
        <div data-options="region:'center',title:'Visor de Rutas' ">
      
    <div style="margin-top:10px">
        <select class="easyui-combobox" id="asesor"    name="asesor" label="Asesor:" style="width:40%;">
         </select>
      </div>
 
     <div id="map" style="width: 100%; height:600px;"></div>
     
     
        </div>
    </div> 
	
	<script>
var KP_LAT = -1.237466;
var KP_LON = -78.6276781;


 $(function () {
      

        $('#asesor').combobox({
                url: 'php/asesor/select_cmb_asesor.php',
                valueField: 'ase_id',
                textField: 'ase_nombre',
                onChange: function (value) {
                  getdata(value);
                    
                }

            });

      });
	const map = L.map('map').setView([-1.237466,-78.6276781], 16);

	const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

      const kisapCoop = L.circle([-1.237466,-78.6276781], {
		color: 'blue',
		fillColor: 'blue',
		fillOpacity: 0.1,
		radius: 15
	}).addTo(map).bindPopup('Cooperativa');

 
 function getdata(inase_id) {
        $.ajax({
          type: "POST",
          url:  "php/movil/get_lugares.php?ase_id="+inase_id,
      
          success: function (response) {
            let array = [L.latLng(KP_LAT, KP_LON)];
            response.forEach((element) => {
              array.push(L.latLng(element.lug_latitud, element.lug_longitud));
            });
            verdirecciones(array);
            $("#dg").datagrid({
              data: response,
            });
            $("#spinner").hide();
          },
        });
      }
	    function verdirecciones(inwaypoints) {
        var rrr = L.Routing.control({
          waypoints: inwaypoints,
          language: "es-ES",
          routeWhileDragging: true,
        }).addTo(map);
      }
 
function myFunction(item) {
  console.log(item);
  
  
			const circle = L.circle([item.lat,item.lng], {
		color: 'blue',
		fillColor: '#f03',
		fillOpacity: 0.5,
		radius: 1
	}).addTo(map).bindPopup('I am a circle.');
}
</script>

</body>

</html>