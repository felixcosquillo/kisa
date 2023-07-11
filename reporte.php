<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title> KISAPINCHA </title>
    <link rel="icon" href="uti.ico">
    <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="themes/icon.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
 
    <script type="text/javascript" src="js/datagrid-export.js"></script>
    <script type="text/javascript" src="js/easyui-lang-es.js"></script>
</head>

<body>
    <div class="easyui-layout" fit="true">
        <?php include('encabezado.php') ?>
        <div data-options="region:'west',split:true" title="Opciones" style="  width:200px; ">
            <?php include('menu.php') ?>
        </div>
        <div data-options="region:'center',title:'Asesores' ">
            <h2>Reporte</h2>
            
            <a href="#" onclick="imprimir()" class="easyui-linkbutton" data-options="iconCls:'icon-print'" style="width:80px">Imprimir</a>
     
            <table id="dg" title="Mi Asesores" class="easyui-datagrid" style="width:100%;height:100%"
                url="php/reporte/select_r1.php" toolbar="#toolbar" pagination="false" rownumbers="true"
                fitColumns="true" singleSelect="true">
                <thead>
                    <tr> 
                        <th field="sup_nombre" width="50">Supervisor</th>
                        <th field="ase_nombre" width="50">Asesor </th>
                        <th field="lug_nombre" width="50">Clinte/lugar</th>
                        <th field="lug_hora_inicio" width="50">Inicio</th>
                        <th field="lug_hora_fin" width="50">Fin</th>
                        <th field="obs_texto" width="50">Observación</th>
                      

                    </tr>
                </thead>
            </table>
 

       
            <script type="text/javascript">
            var url;

            function print_xls(){

          
$('#dg').datagrid('print','DataGrid'); 
            }
             
            
            function imprimir(){

   // export to excel
$('#dg').datagrid('print',' Kisapincha '); 
}

            </script>
        </div>
    </div>
</body>

</html>