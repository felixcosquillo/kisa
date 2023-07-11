 <style>
.icon-large-picture {
background: url(themes/icons/usuarios.png) no-repeat center center;
}

.icon-large-supervisor {
background: url(themes/icons/supervisor.png) no-repeat center center;
}
.icon-large-asesor{
background: url(themes/icons/asesor.png) no-repeat center center;
}

.icon-large-asesor{
background: url(themes/icons/asesor.png) no-repeat center center;
}
.icon-large-lugares{
background: url(themes/icons/lugares.png) no-repeat center center;
}
.icon-large-salir{
background: url(themes/icons/salir.png) no-repeat center center;
}
.icon-large-mapa{
background: url(themes/icons/mapa.png) no-repeat center center;
}
.icon-large-reporte{
background: url(themes/icons/print.png) no-repeat center center;
}
 </style>    
 <div style="padding:5px 0;">
 <center>
 <a href="usuarios.php" class="easyui-linkbutton" data-options="iconCls:'icon-large-picture',size:'large',iconAlign:'top'">&nbsp; &nbsp; Usuarios&nbsp; &nbsp; </a>
 <p></p>
 <a href="supervisor.php" class="easyui-linkbutton" data-options="iconCls:'icon-large-supervisor ',size:'large',iconAlign:'top'">Supervidores</a>
 <p></p>
 <a href="asesor.php" class="easyui-linkbutton" data-options="iconCls:'icon-large-asesor',size:'large',iconAlign:'top'">&nbsp; &nbsp;Asesores&nbsp; &nbsp;</a>
 <p></p>
 <a href="geovisor.php" class="easyui-linkbutton" data-options="iconCls:'icon-large-lugares',size:'large',iconAlign:'top'">&nbsp;&nbsp; &nbsp;Vistas &nbsp; &nbsp;&nbsp;</a>
 <p></p>
 <a href="reporte.php" class="easyui-linkbutton" data-options="iconCls:'icon-large-reporte',size:'large',iconAlign:'top'">&nbsp;&nbsp; &nbsp;Reporte &nbsp; &nbsp;&nbsp;</a>


 <!--
 <p></p>
 <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-large-mapa',size:'large',iconAlign:'top'">&nbsp;&nbsp; &nbsp;Traking&nbsp;&nbsp; &nbsp;</a>
  -->
 <p></p>
 <a href="#" onclick="salir()" class="easyui-linkbutton" data-options="iconCls:'icon-large-salir',size:'large',iconAlign:'top'">&nbsp;&nbsp;&nbsp; &nbsp;Salir&nbsp;&nbsp; &nbsp;&nbsp;</a>


</center>
</div>

<script>
   
    if( sessionStorage.getItem('_user') == undefined)
    {
        window.location.href = "login.html";
    }
 

    function salir(){
        $.messager.confirm('Confirmar','Esta seguro de Salir?',function(r){
      if (r){
        sessionStorage.clear();
        window.location.href = "login.html";
      }
    });
    }
</script>    

 