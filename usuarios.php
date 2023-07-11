<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title> KISAPINCHA </title>
    <link rel="icon"  href="uti.ico">
    <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="themes/icon.css"> 
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/easyui-lang-es.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
 
</head>
<body> 
    <div class="easyui-layout" fit="true" >
    <?php include('encabezado.php') ?>   
        <div data-options="region:'west',split:true" title="Opciones" style="  width:200px; " >        
        <?php include('menu.php') ?>
        </div>
        <div data-options="region:'center',title:'Usuarios' ">
        <h2>Administración de Usuarios</h2>
    <p>Haga clic en los botones de la barra de herramientaspara realizar acciones básicas.</p>
    
    <table id="dg" title="Mi usuarios" class="easyui-datagrid" style="width:100%;height:100%"
            url="php/usuario/select_usuario.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="usu_login" width="50">Usuario</th>
                <th field="usu_nombre" width="50">Nombre </th>
           
                
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add2" plain="true" onclick="newUser()">AGREGAR</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">EDITAR</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">ELIMINAR</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Información de usuario </h3>
            <div style="margin-bottom:10px">
                <input  id="usu_login" name="usu_login" class="easyui-textbox" labelPosition="top"  required="true" label="Nombre de Usuario:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="usu_nombre" class="easyui-textbox" required="true"  labelPosition="top"  label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="usu_password" class="easyui-textbox" required="true" labelPosition="top"  label="Password:" style="width:100%">
            </div>

            <div style="margin-bottom:20px">
            <select name="usu_rol"  class="easyui-combobox" name="state" label="Rol:" required="true" labelPosition="top" style="width:100%;">
                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                <option value="ASESOR">ASESOR</option>
                <option value="SUPERVISOR">SUPERVISOR</option>            
            </select>
        </div>
             
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;
 
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Usuario');
            $('#usu_login').textbox('readonly',false);
            
            $('#fm').form('clear');
            url = 'php/usuario/insert_usuario.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Modificar Usuario');
                $('#fm').form('load',row);
               
                $('#usu_login').textbox('readonly',true);
                url = 'php/usuario/update_usuario.php?id='+row.id;
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirme','¿Estás seguro de que quieres eliminar a este usuario?',function(r){
                    if (r){
                        $.post('php/usuario/delete_usuario.php',{id:row.usu_login},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
    </script>
        </div>
    </div> 
</body>
</html>