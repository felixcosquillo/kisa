var map;
var ctx;
var footer;
var myChart;
var myChartmobile;
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $('#btnBuscar').bind('click', function () {
        getEstablecimientos('null','null');
    });

    $('#btnindicadores').bind('click', function () {
        $('#win_grafico').window('open');
    });
    getindicadoresgeovisor();
    //dibujaDPA();



    ctx = document.getElementById('myChart');
    ctxmobile = document.getElementById('myChartmobile');
    

    footer = (tooltipItems) => {
        let sum = 0;
        tooltipItems.forEach(function (tooltipItem) {
            sum += tooltipItem.parsed.y;
        });
        return 'Porcentaje: ' + sum + '%';
    };
    $('#mapa_leyenda').hide();

});

var v_slect_actividad;

const mapDiv = document.getElementById("map");
//extent: [-79.38444219,-0.73612992,-77.79368746,0.32768705],
var southWest = L.latLng(0.32768705, -77.79368746,),
    northEast = L.latLng(-0.73612992, -79.38444219),
    bounds = L.latLngBounds(southWest, northEast);

map = L.map('map', {
    center: [-0.318544, -78.419266],
    fullscreenControl: {
        pseudoFullscreen: false
    },
    zoom: 10,
    maxBounds: bounds
});

L.control.resetView({
    position: "topleft",
    title: "Reset view",
    latlng: L.latLng([-0.318544, -78.419266]),
    zoom: 10,
}).addTo(map);

let tile= L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
 
L.Control.measureControl().addTo(map);
var printer = L.easyPrint({
    tileLayer: tile,
    sizeModes: ['Current', 'A4Landscape', 'A4Portrait'],
    filename: 'miMapa',
    exportOnly: true,
    hideControlContainer: true
}).addTo(map);

function manualPrint () {
  printer.printMap("A4Landscape page", 'MyManualPrint')
}

function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}
//fill: #317581;
//define a function to get and parse geojson from URL
async function getGeoData(url) {
    let response = await fetch(url);
    let data = await response.json();
    return data;
}





// get color depending on population density value
function getColor(d) {
    return d > 1000 ? '#800026' :
        d > 500 ? '#BD0026' :
            d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                    d > 50 ? '#FD8D3C' :
                        d > 20 ? '#FEB24C' :
                            d > 10 ? '#FED976' : '#FFEDA0';
}

function getColorMapa(valor, rangos) {

    let color = 'rgba(255, 255, 255, 0.1)';
    if (rangos[0].limite_inferior <= valor && rangos[0].limite_superior >= valor) {
        color = rangos[0].color
    }
    if (rangos.length > 1) {

        if (rangos[1].limite_inferior <= valor && rangos[1].limite_superior >= valor) {
            color = rangos[1].color
        }
        if (rangos[2].limite_inferior <= valor && rangos[2].limite_superior >= valor) {
            color = rangos[2].color
        }
        if (rangos[3].limite_inferior <= valor && rangos[3].limite_superior >= valor) {
            color = rangos[3].color
        }
        if (rangos[4].limite_inferior <= valor && rangos[4].limite_superior >= valor) {
            color = rangos[4].color;

        }
    }

    return color;
}



/*
const legend = L.control({ position: 'bottomright' });

legend.onAdd = function (map) {

    const div = L.DomUtil.create('div', 'info legend');
    const grades = [0, 10, 20, 50, 100, 200, 500, 1000];
    const labels = [];
    let from, to;

    for (let i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];

        labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
    }

    div.innerHTML = labels.join('<br>');
    return div;
};

legend.addTo(map);
*/


$(document).ready(function () {
    getEstablecimientos();
    getActividad();
    getActividades();
});






function addTopoData(topoData) {
    topoLayer.addData(topoData);
    // topoLayer.addTo(map);
}

function onClick(e) {
    getEstablecimiento(e.target.options.establecimiento.name);

}

function doSearch(value) {
    alert('You input: ' + value);
}
function verinfo(value) {
    getEstablecimiento(value);
}


function dibujaDPA() {
    L.TopoJSON = L.GeoJSON.extend({
        addData: function (data) {
            var geojson, key;
            if (data.type === "Topology") {
                for (key in data.objects) {
                    if (data.objects.hasOwnProperty(key)) {
                        geojson = topojson.feature(data, data.objects[key]);
                        L.GeoJSON.prototype.addData.call(this, geojson);
                    }
                }
                return this;
            }
            L.GeoJSON.prototype.addData.call(this, data);
            return this;
        }
    });
    L.topoJson = function (data, options) {
        return new L.TopoJSON(data, options);
    };

    var geojson = L.topoJson(null, {
        style: function (feature) {
            return {
                color: "#3B71CA",
                opacity: 1,
                weight: 2,
                fillColor: getColor(feature.properties.DPA_DESPAR),
                fillOpacity: 0.1,
            }
        },
        onEachFeature: function (feature, layer) {
            layer.bindTooltip(feature.properties.DPA_DESPAR, {
                permanent: true,
                direction: "center",
                className: "my-labels"
            }).openTooltip();

            layer.on({
                mouseover: function highlightFeature(e) {
                    const layer = e.target;
                    layer.setStyle({
                        weight: 5,
                        color: '#666',
                        dashArray: '',
                        fillOpacity: 0.7
                    });

                    layer.bringToFront();


                },
                mouseout: function resetHighlight(e) {
                    geojson.resetStyle(e.target);

                },
                click: zoomToFeature
            });


        }
    }).addTo(map);
    $('#spinner').show();
    getGeoData('parroquias.json').then(data => {
        $('#spinner').hide();
        geojson.addData(data);

    });
}

function getEstablecimientos() {
    getEstablecimientosfiltros('null','null') 
}
function getEstablecimientosfiltros(act_codigo,subact_codigo) {

    let nombre = 'null';
    let parroquia = 'null';
    let actividad = 'null';
    let subactividad = 'null';
    let tmpnombre = $('#txtNombre').val();
    let tmpparr = $('#cmb_parroquia').val();
    let tmpactividad = $('#cmb_actividad').val();
    
    if(act_codigo!='null' ){
        actividad =  act_codigo;
    }
    if(subact_codigo!='null' ){
        subactividad =  subact_codigo;
    }
 

    if (tmpnombre) {
        nombre = tmpnombre;
    }
    if (tmpparr != '000000') {
        parroquia = tmpparr;
    }
    if (v_slect_actividad) {
        actividad = v_slect_actividad;
    }
    $('#spinner').show();
    $.ajax({
        url: '/api/method/uio_turismo.swp.get_establecimientos_filters?nombre=' + nombre + '&parroquia=' + parroquia + '&actividad=' + actividad + '&subactividad=' + subactividad ,
        type: 'GET',
        success: function (r) {
            map.eachLayer((layer) => {
                if (layer['_latlng'] != undefined) {
                    layer.remove();
                }

            });

            r.message.forEach((row) => {
                if (row.est_latitud != null && row.est_latitud != ' ') {

                        console.log(row.subact_icono);
                        if( row.subact_icono)
                        {
                            var icono = L.icon({
                                iconUrl: row.subact_icono,                       
                            
                                iconSize:     [50, 50], // size of the icon
                             
                            });
        
                            L.marker([row.est_latitud, row.est_longitud],   {icon: icono} ,{ 'establecimiento': row } ).addTo(map).on('click', onClick);
                        }
                        else{
                            L.marker([row.est_latitud, row.est_longitud]  ,{ 'establecimiento': row } ).addTo(map).on('click', onClick);
                        }
                   
                }
            });

            dibujaTablaMobile( r.message);

            $('#gdEstablecimientos').datagrid({
                onSelect: function (rowIndex, rowData) {
                },
                columns: [[
                    {
                        field: 'name2', title: ' ', width: 40,
                        formatter: function (value, row, index) {

                            return ` <a href="#"> <img src='view_icon.png'  onclick='verinfo("${value}")' /> </a> `;

                        }
                    },
                    { field: 'name', title: '# Registro' },
                    { field: 'est_nombre', title: 'Nombre' },
                    { field: 'parroquia', title: 'Parroquia' },
                    { field: 'act_desc', title: 'Actividad' },
                    { field: 'subact_desc', title: 'Sub Actividad' }
                ]],

                data: r.message,


            });
            $('#spinner').hide();
        }
    });
}


function getEstablecimiento(name) {
    $.ajax({
        url: '/api/method/uio_turismo.swp.get_establecimiento?name=' + name,
        type: 'GET',
        success: function (r) {

            let data = r.message;
            map.setView([r.message.est_latitud, r.message.est_longitud], 19);
            let html = ` <div style="margin-bottom:5px">        
</div>
<div style="margin-bottom:5px;font-size:14px">
    <b> Ruc :</b>  ${data.est_ruc}
</div>
<div style="margin-bottom:5px;font-size:14px">
    <b> Nombre :</b>  ${data.est_nombre}
</div>

<div style="margin-bottom:5px;font-size:14px">
    <b> Razón Social :</b>  ${data.est_razonsocial}
</div>

<div style="margin-bottom:5px;font-size:14px">
    <b> Representante :</b>  ${data.est_representantel}
</div>

<div style="margin-bottom:5px;font-size:14px">
    <b> Nombre de Contacto :</b>  ${data.est_nomcontacto}
</div>

<div style="margin-bottom:5px;font-size:14px">
    <b> Parroquia :</b>  ${data.parroquia}
</div>

`;
            $('#win_detalles').html(html);
            $('#win_detalles').window('open');

        }
    });
}
function getActividad() {
    $.ajax({
        url: '/api/method/uio_turismo.swp.getActividad',
        type: 'GET',
        success: function (r) {
            $('#cmb_actividad').combobox({
                data: r.message,
                onChange: function (value) {
                    v_slect_actividad = value;
                    getSubActividad(value);
                }
            });
        }
    });
}
function getSubActividad(value) {
    $.ajax({
        url: '/api/method/uio_turismo.swp.getSubActividad?act_codigo=' + value,
        type: 'GET',
        success: function (r) {
            $('#cmb_subactividad').combobox({
                data: r.message,
            });
        }
    });
}

function getindicadoresgeovisor() {
    $.ajax({
        url: '/api/method/uio_turismo.swp.getindicadoresgeovisor_serievalor',
        type: 'GET',
        success: function (r) {
           
            formato2_ind(r.message);

        }
    });
}

function formato1_ind(data) {
    let html_full = '';
    data.forEach((row) => {
        let html_det_ind = '';
        row.indicadores.forEach((rwi) => {
            html_det_ind += ` <li onClick="VerIndicador('${rwi.id} ')"> ${rwi.text}  </li>`;
        });

        let html_ind = `   <div class="accordion" id="acd_indicadores">
         <div class="accordion-item">
            <h2 class="accordion-header" id="head_ind_${row.id}">
               <button class="accordion-button categorias" type="button" data-mdb-toggle="collapse" data-mdb-target="#acd_det_${row.id}"
                  aria-expanded="true" aria-controls="acd_det_${row.id}">
               <strong style="color:#fff !important; font-size:11px"> ${row.text}  </strong>
               </button>
            </h2>
            <div id="acd_det_${row.id}" class="accordion-collapse  " aria-labelledby="head_ind_${row.id}"
               data-mdb-parent="#acd_indicadores">
               <div class="indicadores">                        
               ${html_det_ind}
               </div>
            </div>
         </div>              
      </div>`;
        html_full += html_ind;

    });
    $('#collapseTwo').html(html_full);
}

function formato2_ind(data) {
    let html_full = ' <ul  > ';
    data.forEach((row) => {
        let html_det_ind = '';
        row.indicadores.forEach((rwi) => {
            html_det_ind += ` <li  class="nombre_indicador"    onClick="verindicadordetalle('${rwi.id}')" >  ${rwi.text}</li> `;
        });
        let html_ind = ` <li class="nombre_indicador_grupo"  >${row.text} </li>
      <ul>
      ${html_det_ind} 
      </ul>`;

        html_full += html_ind;

    });
    html_full += ` <lu> `;
    $('#collapseTwo').html(html_full);
}

function verindicadordetalle(ind_codigo) {

    /* map.eachLayer(function (layer) {
         if (layer instanceof L.TopoJSON) {
             // layers.push(layer);
             console.log(layer);
         }
     });*/

    // 'eje_codigo':eje_codigo

    $('#spinner').show();



    $.ajax({
        url: '/api/method/uio_turismo.swp.leyenda_tematica_inicial',
        type: 'GET',
        data: {
            'ind_codigo': ind_codigo
        },
        success: function (r) {
            $('#spinner').hide();
            $('#mapa_leyenda').show();
         
            
           // dibujaMapaTematico(r.message,null);
            dibujaLeyendaMapa(r.message);
            dibujaGrafico(r.message);
        },
        error: function (r) {
            $('#spinner').hide();
         
            
        }
    });

}

function dibujaMapaTematico(resultados,serval_categoria) {
    
    if (serval_categoria==null)
    {
       serval_categoria = resultados.series[0].serval_categoria;
    }
    map.eachLayer(function (layer) {
      if ( layer instanceof L.GeoJSON) {
        layer.remove();
       }
    });

    L.TopoJSON = L.GeoJSON.extend({
        addData: function (data) {
            var geojson, key;
            if (data.type === "Topology") {
                for (key in data.objects) {
                    if (data.objects.hasOwnProperty(key)) {
                        geojson = topojson.feature(data, data.objects[key]);
                        L.GeoJSON.prototype.addData.call(this, geojson);
                    }
                }
                return this;
            }
            L.GeoJSON.prototype.addData.call(this, data);
            return this;
        }
    });
    L.topoJson = function (data, options) {
        return new L.TopoJSON(data, options);
    };

    var geojson = L.topoJson(null, {
        style: function (feature) {
            return {
                color: "#195EAA", 
                opacity: 1,
                weight: 1,
                fillColor: getColorMapa(feature.properties.valor, resultados.rangos),
                fillOpacity: 0.8,
            }
        },
        onEachFeature: function (feature, layer) {
        
            layer.bindTooltip(feature.properties.DPA_DESPAR + ' ' + feature.properties.valor + '%', {
                permanent: true,
                direction: "center",
                className: "my-labels"
            }).openTooltip();

            layer.on({
                mouseover: function highlightFeature(e) {
                    const layer = e.target;
                    layer.setStyle({
                        weight: 5,
                        color: '#666',
                        dashArray: '',
                        fillOpacity: 0.7
                    });
                    layer.bringToFront();
                },
                mouseout: function resetHighlight(e) {
                    geojson.resetStyle(e.target);

                },
                click: zoomToFeature
            });


        }
    }).addTo(map);
    $('#spinner').show();

    getGeoData('parroquias.json').then(data => {
        data.objects.parroquias.geometries.forEach((gjson) => {
         
            resultados.valores.forEach((res) => {
                if (res.ind_dpa == gjson.properties.DPA_PARROQ && serval_categoria == res.serval_categoria  ) {
                    gjson.properties.valor = res.serval_valor;
                }
            });
        });        
        geojson.addData(data);
        $('#spinner').hide();
    });
}

function dibujaLeyendaMapa(data) {
    let html_indicador = `<b> ${data.indicador.ind_codigo}  ${data.indicador.ind_nombre} <b>`;
    let html_anio = ``;
    let html_serie = ``;
    let array = []
    let array_cat = []
    data.periodos.forEach((res) => {
        array.push({ "value": res.eje_codigo, "text": res.eje_codigo })
    });

    data.series.forEach((serie) => {
        array_cat.push({ "value": serie.serval_categoria, "text": serie.serval_categoria })

    });
    $('#cmbCategorias').combobox({
        data: array_cat,
        editable: false,
        onSelect: function(valor){
           
            dibujaMapaTematico(data,valor.value);
        }
    });
    $('#cmbCategorias').combobox('setValue', data.series[0].serval_categoria);
    $('#cmbPeriodos').combobox({
        data: array,
        editable: false
    });
    $('#cmbPeriodos').combobox('setValue', data.periodos[0].eje_codigo);

    data.rangos.forEach((res) => {
        html_serie += `<div> <i style=" height: 25px ; width: 25px; background-color:${res.color}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i> ${res.limite_inferior} -  ${res.limite_superior}  </div> `;
    });

    $('#infmap_indicador').html(html_indicador);
    //   $('#infmap_anio').html(html_anio);
    $('#infmap_serie').html(html_serie);


}
function dibujaGrafico(data){
    let labels=[];
   
    let vdatasets=[];
    data.parroquias.forEach((res) => {
        labels.push( res.ind_nparroquia);
       
    });

    data.series.forEach((serie) => {
        let valores=[];
            data.valores.forEach((valor) => {     
                if( serie.serval_categoria == valor.serval_categoria )          
                   valores.push( valor.serval_valor);
            });
        
        vdatasets.push(  {
            label:serie.serval_categoria,
            data:valores,           
            hoverBorderWidth: 6,
            hoverBorderColor: '#212F3C',
            }  );

    });
 
const indata = {
  labels: labels,
  datasets: vdatasets
};

setData(indata, data.indicador.ind_nombre );
}

function setData(indata, texto) {
 
    if (myChart!=undefined &&  myChart) {
        myChart.destroy();
    }
 
    myChart = new Chart(ctx, {
        type: 'bar',
        data: indata,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: texto
                },

                tooltip: {
                    callbacks: {
                        footer: footer,
                    }
                }

            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        }
    });

    myChartmobile = new Chart(ctxmobile, {
        type: 'bar',
        data: indata,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: texto
                },

                tooltip: {
                    callbacks: {
                        footer: footer,
                    }
                }

            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        }
    });
    
}

function boton_grafico(){
    if( $( window ).width() < 400){
        $('#modal_grafico_mobil').modal('show');
    }
    else{
        $('#win_grafico') .window('open');
    }
}
function boton_cerrar(){
    map.eachLayer(function (layer) {
     
        if ( layer instanceof L.GeoJSON) {
            layer.remove();
         }
      });
    
      $('#mapa_leyenda').hide();

}
function boton_ver_establecimientos(){
 

 
    if( $( window ).width() < 400){
        $('#modal_mobile_id').modal('show');
    }
    else{
        $('#win_listado').window('open');
    }
 
 
}

function dibujaTablaMobile(data){
let detalle_html="";
 
    data.forEach((row) => {
        detalle_html += ` <tr>
      
        <td>${row.est_nombre}</td>
        <td>${row.act_desc}</td>
         
      </tr>`;
    });

let html = `    <table class="table">
<thead>
 <tr>
 
 <th scope="col">Nombre</th>
 <th scope="col">Actividad</th>

</tr>
</thead>
<tbody>
 
  ${detalle_html} 
</tbody>
</table>`;




$('#mobile_table_estab').html(html);
}

function getActividades(){
 
    $.ajax({
        url: '/api/method/uio_turismo.swp.getActividades',
        type: 'GET',        
        success: function (r) {
           
            
            dibujaGrupoActividades(r.message);
        },
        error: function (r) {
         
            
        }
    });
}
function dibujaGrupoActividades(datos)
{
    let html_full="";
  
    
    datos.forEach((row) => {
        let detalle_html ='';
        row.subactividades.forEach((sub) => {
            detalle_html+= `<div  >  <img style='height:30px' src='${sub.subact_icono}'  /> <span onclick="filtro_por_subactividad('${row.act_codigo}', '${sub.subact_codigo}') " > ${sub.subact_desc}</span>  </div>`;
          //  detalle_html += ` <img style='height:24px' src='${sub.subact_icono}'  />  <li onclick="filtro_por_subactividad('${row.act_codigo}', '${sub.subact_codigo}') " > ${sub.subact_desc}</li> `;    
        });

        let html = `   <div class="accordion-header2" >  <img style='height:24px' src='${row.act_icono}'  /> <span style='padding-left: 5px;'>  ${row.act_desc} </span>  </div> 
        <div class="items_actividades" > 
          ${detalle_html}
        </div>`;
        html_full+=html;

    });

  
  $('#lista_actividades_grupo').html(html_full);
}

function filtro_por_subactividad( actividad,subactividad ){
 
    getEstablecimientosfiltros(actividad,subactividad) 

}
 